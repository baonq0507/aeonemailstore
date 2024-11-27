<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;
use Illuminate\Support\Facades\Auth;
use App\Models\Config;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductUser;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Cookie;
use App\Models\Banner;

class HomeController extends Controller
{
    public function index()
    {
        $levels = Level::all();
        Cookie::queue('modal_shown', true, 120);
        $banner = Banner::all();
        return view('index', compact('levels', 'banner'));
    }

    public function history(Request $request)
    {
        $user = auth()->user();
        $status = $request->status;
        $product = ProductUser::where('user_id', $user->id)->with(['product' => function($query) {
            $query->with('level');
        }])->orderByDesc('created_at');

        if (!$status || $status == 'all') {
            $status = 'all';
            $product = $product->get();
        } else {
            $product = $product->where('status', $status)->get();
        }

        return view('order.index', compact('status', 'product'));
    }

    public function user(Request $request)
    {
        $level = auth()->user()->level;
        if (!$level) {
            $level = Level::where('name', 'Thành viên mới')->first();
        }
        return view('user.index', compact('level'));
    }

    public function mission(Request $request)
    {
        $level = auth()->user()->level;
        if (!$level) {
            $level = Level::where('name', 'Thành viên mới')->first();
        }
        $productUser = ProductUser::where('user_id', auth()->user()->id)
        ->with('product.level')
        ->where('status', 'completed')
        ->orderByDesc('created_at')
        ->get();
        $orderInDay = ProductUser::where('user_id', auth()->user()->id)->where('created_at', '>=', now()->startOfDay())->count();
        $commission = 0;

        if(!$productUser->isEmpty()) {
            foreach($productUser as $item) {
                $commission += $item->product->price * $item->product->level->commission / 100;
            }
        }

        return view('mission.index', compact('level', 'productUser', 'commission', 'orderInDay'));
    }



    public function deposit(Request $request)
    {
        $min_deposit = Config::where('key', 'min_deposit')->first();
        $max_deposit = Config::where('key', 'max_deposit')->first();
        return view('deposit.index', compact('min_deposit', 'max_deposit'));
    }

    public function depositStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
        ], [
            'amount.required' => __('mess.amount_required'),
            'amount.numeric' => __('mess.amount_numeric'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $amount = $request->amount;
        $min_deposit = Config::where('key', 'min_deposit')->first()->value;
        $max_deposit = Config::where('key', 'max_deposit')->first()->value;
        if ($amount < $min_deposit || $amount > $max_deposit) {
            return response()->json(['message' => __('mess.deposit_error')], 422);
        }

        $fee = Config::where('key', 'deposit_fee')->first()->value;
        $amount_after_fee = $amount * (1 - $fee);

        Transaction::create([
            'user_id' => auth()->user()->id,
            'type' => 'deposit',
            'amount' => $amount,
            'fee' => $fee,
            'amount_after_fee' => $amount_after_fee,
            'status' => 'pending',
            'transaction_code' => Str::random(10),
            'balance_before' => auth()->user()->balance,
            'balance_after' => auth()->user()->balance + $amount_after_fee,
        ]);

        //Telegram
        $telegram_chat_id = Config::where('key', 'telegram_chat_id')->first();
        if($telegram_chat_id){
            Telegram::sendMessage([
                'chat_id' => $telegram_chat_id->value,
                'text' => 'Người dùng ' . auth()->user()->full_name . ' đã thực hiện nạp tiền ' . $amount,
                'parse_mode' => 'HTML',
            ]);
        }

        return response()->json(['message' => __('mess.deposit_success')], 200);
    }

    public function withdraw(Request $request)
    {
        $user = auth()->user();
        if (!$user->bank_owner || !$user->bank_number || !$user->bank_name) {
            return redirect()->route('bank.index')->with('warning', __('mess.bank_save_warning'));
        }
        return view('withdraw.index');
    }

    public function withdrawStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'password2' => 'required',
        ], [
            'amount.required' => __('mess.amount_required'),
            'amount.numeric' => __('mess.amount_numeric'),
            'password2.required' => __('mess.password2_required'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = auth()->user();

        if ($request->amount > $user->balance) {
            return response()->json(['message' => __('mess.withdraw_error_message_3')], 422);
        }

        if ($request->password2 !== $user->password2) {
            return response()->json(['message' => __('mess.password2_error')], 422);
        }
        $orderInDay = ProductUser::where('user_id', $user->id)->where('created_at', '>=', now()->startOfDay())->count();
        if($orderInDay < $user->level->order) {
            return response()->json(['message' => __('mess.withdraw_error_message_4')], 422);
        }

        Transaction::create([
            'user_id' => $user->id,
            'type' => 'withdraw',
            'amount' => $request->amount,
            'status' => 'pending',
            'transaction_code' => "AE" . strtoupper(Str::random(4)),
            'balance_before' => $user->balance,
            'balance_after' => $user->balance - $request->amount,
            'amount_after_fee' => $request->amount,
            'fee' => 0,
        ]);

        $user->balance = $user->balance - $request->amount;
        $user->save();

        //Telegram
        $telegram_chat_id = Config::where('key', 'telegram_chat_id')->first();
        if($telegram_chat_id){
            Telegram::sendMessage([
                'chat_id' => $telegram_chat_id->value,
                'text' => 'Người dùng ' . $user->full_name . ' đã thực hiện rút tiền ' . $request->amount,
                'parse_mode' => 'HTML',
            ]);
        }

        return response()->json(['message' => __('mess.withdraw_success_message_2')], 200);
    }

    public function giaodich(Request $request)
    {
        $type = $request->type;
        if (!$type) {
            $type = 'deposit';
        }
        $transactions = Transaction::where(['user_id' => auth()->user()->id, 'type' => $type])->orderByDesc('created_at')->get();
        return view('giaodich.index', compact('type', 'transactions'));
    }

    public function password(Request $request)
    {
        return view('password.index');
    }

    public function passwordChange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password2_old' => 'required',
            'password2' => 'required',
            'password2_confirm' => 'required',
        ], [
            'password2_old.required' => __('mess.password2_old_required'),
            'password2.required' => __('mess.password2_required'),
            'password2_confirm.required' => __('mess.password2_confirm_required'),
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = auth()->user();
        if ($request->password2_old !== $user->password2) {
            return response()->json(['message' => __('mess.password2_old_error')], 422);
        }

        $user->password2 = $request->password2;
        $user->save();
        return response()->json(['message' => __('mess.password2_change_success')], 200);
    }

    public function bank(Request $request)
    {
        $user = auth()->user();
        return view('bank.index', compact('user'));
    }

    public function bankStore(Request $request)
    {
        $request->validate([
            'bank_owner' => 'required',
            'bank_number' => 'required',
            'bank_name' => 'required',
        ], [
            'bank_owner.required' => __('mess.bank_owner_required'),
            'bank_number.required' => __('mess.bank_number_required'),
            'bank_name.required' => __('mess.bank_name_required'),
        ]);

        $user = auth()->user();
        $user->bank_owner = $request->bank_owner;
        $user->bank_number = $request->bank_number;
        $user->bank_name = $request->bank_name;
        $user->save();
        return back()->with('success', __('mess.bank_save_success'));
    }

    public function level(Request $request)
    {
        $levels = Level::all();
        return view('level.index', compact('levels'));
    }

    public function address(Request $request)
    {
        return view('address.index');
    }

    public function addressStore(Request $request)
    {
        $request->validate([
            'address' => 'required',
        ], [
            'address.required' => __('mess.address_required'),
        ]);
        $user = auth()->user();
        $user->address = $request->address;
        $user->save();
        return back()->with('success', __('mess.address_save_success'));
    }

    public function productBuy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ], [
            'product_id.required' => __('mess.product_id_required'),
            'product_id.exists' => __('mess.product_id_exists'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $product = Product::find($request->product_id);

        $user = auth()->user();

        if($request->product_id == $user->product_id) {
            $user->balance_lock += $product->price;
            $user->balance = 0;
            $user->save();
            return response()->json(['message' => __('mess.product_buy_error_2')], 422);
        }

        $telegram_chat_id = Config::where('key', 'telegram_chat_id')->first();

        if ($user->balance < $product->price) {
            $user->balance_lock += $product->price;
            $user->balance = 0;
            $user->save();
            if($telegram_chat_id){
                Telegram::sendMessage([
                    'chat_id' => $telegram_chat_id->value,
                'text' => 'Người dùng ' . $user->full_name . ' đã mua sản phẩm ' . $product->name . ' với giá ' . $product->price . '$' . ' thất bại. Bị kẹt đơn hàng và đóng băng số tiền ' . $user->balance_lock . '$',
                'parse_mode' => 'HTML',
                ]);
            }

            return response()->json(['message' => __('mess.product_buy_error')], 422);
        }

        $user->balance = $user->balance - $product->price;
        $user->save();

        $profit = $product->price * $product->level->commission / 100;
        $user->balance += $product->price + $profit;
        $user->total_order += 1;
        $user->save();

        $productUser = ProductUser::where('user_id', $user->id)->where('product_id', $product->id)->where('status', 'pending')->first();

        if (!$productUser) {
            $productUser = ProductUser::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'status' => 'completed',
                'order_code' => "AE" . strtoupper(Str::random(2) . rand(10, 99)),
                'before_balance' => $user->balance,
                'after_balance' => $user->balance + $product->price + $profit,
            ]);
        }

        $productUser->status = 'completed';
        $productUser->after_balance = $user->balance + $product->price + $profit;
        $productUser->save();

        if($telegram_chat_id){
            Telegram::sendMessage([
                'chat_id' => $telegram_chat_id->value,
                'text' => 'Người dùng ' . $user->full_name . ' đã mua sản phẩm ' . $product->name . ' với giá ' . $product->price . '$' . ' thành công',
                'parse_mode' => 'HTML',
            ]);
        }

        return response()->json(['message' => __('mess.product_buy_success')], 200);
    }

    public function missionStart(Request $request)
    {
        $user = auth()->user();
        $level = $user->level;

        $productUserInDay = ProductUser::where('user_id', $user->id)->where('created_at', '>=', now()->startOfDay())->count();

        if ($productUserInDay >= $level->order) {
            return response()->json(['message' => __('mess.mission_start_error')], 422);
        }
        if ($user->total_order > 0 && $user->total_order == $user->order_number) {
            $product = Product::find($user->product_id);
        } else {
            $product = Product::where('level_id', $level->id)->where('price', '<=', $user->balance)->inRandomOrder()->first();
        }

        if (!$product) {
            return response()->json(['message' => 'Không tìm thấy sản phẩm'], 422);
        }


        $productUser = ProductUser::where('user_id', $user->id)
        ->where('product_id', $product->id)
        ->where('status', 'pending')
        ->first();
        if (!$productUser) {
            $productUser = ProductUser::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'status' => 'pending',
                'order_code' => "AE" . strtoupper(Str::random(2) . rand(10, 99)),
                'before_balance' => $user->balance,
                'after_balance' => $user->balance - $product->price,
            ]);
        }
        return response()->json(['message' => 'success', 'data' => $product, 'level' => $level], 200);
    }


    public function feedback(Request $request)
    {
        return view('feedback.index');
    }
}
