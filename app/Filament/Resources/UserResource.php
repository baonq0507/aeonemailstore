<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Illuminate\Support\Str;
use App\Models\Transaction;
use App\Models\ProductUser;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Quản lý';

    protected static ?string $label = 'Người dùng';

    protected static ?string $navigationLabel = 'Người dùng';

    public static function getEloquentQuery(): Builder
    {
        return User::query()->orderBy('created_at', 'desc');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin người dùng')
                    ->schema([
                        TextInput::make('full_name')
                            ->label('Họ tên')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone_number')
                            ->label('Số điện thoại')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('password')
                            ->label('Mật khẩu')
                            ->password()
                            ->required(fn(User $user) => is_null($user->id))
                            ->visible(fn(User $user) => is_null($user->id))
                            ->maxLength(255),
                        Select::make('level_id')
                            ->label('Cấp độ')
                            ->relationship('level', 'name')
                            ->required(),
                        //invite code
                        TextInput::make('invite_code')
                            ->label('Mã mời')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->suffixAction(
                                \Filament\Forms\Components\Actions\Action::make('randomize')
                                    ->icon('heroicon-m-arrow-path')
                                    ->action(function ($set) {
                                        $set('invite_code', \Illuminate\Support\Str::random(6));
                                    })
                            ),
                        TextInput::make('password2')
                            ->label('Mật khẩu vốn')
                            ->required(),
                        FileUpload::make('avatar')
                            ->label('Ảnh đại diện')
                            ->directory('avatars')
                            ->image()
                            ->avatar()
                            ->columnSpan(2)
                            ->maxSize(1024),

                    ])->columns(2),

                Section::make('Thông tin ngân hàng')
                    ->schema([
                        TextInput::make('bank_name')
                            ->label('Tên ngân hàng')
                            ->maxLength(255),
                        TextInput::make('bank_number')
                            ->label('Số tài khoản')
                            ->maxLength(255),
                        TextInput::make('bank_owner')
                            ->label('Chủ tài khoản')
                            ->maxLength(255),
                        TextInput::make('address')
                            ->label('Địa chỉ')
                            ->maxLength(255),
                    ])->columns(2),

                Section::make('Số dư')
                    ->schema([
                        TextInput::make('balance')
                            ->label('Số dư')
                            ->numeric(),
                        TextInput::make('balance_lock')
                            ->label('Đóng băng')
                            ->numeric(),
                    ])->columns(2),
                Section::make('Đơn hàng')
                    ->schema([
                        TextInput::make('order_number')
                            ->label('Đơn hàng số')
                            ->hint('Đơn hàng số là số đơn hàng bị kẹt lại')
                            ->numeric(),
                        Select::make('product_id')
                            ->label('Sản phẩm đi kèm khi đơn kẹt')
                            ->searchable()
                            ->preload()
                            ->relationship('product', 'name', fn ($query) => $query->select(['id', 'name', 'price']))
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} - {$record->price}$"),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->searchable()
                    ->sortable()
                    ->label('Họ tên'),
                TextColumn::make('phone_number')
                    ->searchable()
                    ->sortable()
                    ->label('Số điện thoại'),
                TextColumn::make('balance')
                    ->label('Số dư'),
                TextColumn::make('balance_lock')
                    ->label('Đóng băng'),
                TextColumn::make('level.name')
                    ->label('Cấp độ'),
                TextColumn::make('total_order')
                    ->label('Tổng đơn hàng'),
                TextColumn::make('total_order_today')
                    ->formatStateUsing(fn ($state, $record) => $state . '/' . $record->level->order)
                    ->label('Đơn hàng hôm nay'),
                ImageColumn::make('avatar')
                    ->label('Ảnh')
                    ->circular(),
                TextColumn::make('created_at')
                    ->dateTime('d-m-Y')
                    ->label('Ngày tạo'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->before(function (User $record) {
                            Transaction::where('user_id', $record->id)->delete();
                            ProductUser::where('user_id', $record->id)->delete();
                            User::where('referrer_id', $record->id)->update(['referrer_id' => null]);
                        }),
                    Tables\Actions\Action::make('reset_password')
                        ->label('Đặt lại mật khẩu')
                        ->icon('heroicon-o-key')
                        ->form([
                            TextInput::make('password')
                                ->label('Mật khẩu')
                                ->password()
                                ->required(),
                        ])
                        ->modalWidth('sm')
                        ->action(function (array $data, Model $record) {
                            $record->update(['password' => Hash::make($data['password'])]);
                            Notification::make()
                                ->title('Thành công')
                                ->body('Đặt lại mật khẩu thành công')
                                ->success()
                                ->send();
                        }),
                    // add balance
                    Tables\Actions\Action::make('add_balance')
                        ->label('Thêm số dư')
                        ->icon('heroicon-o-plus')
                        ->form([
                            TextInput::make('balance')
                                ->label('Số dư')
                                ->numeric()
                                ->required(),
                        ])
                        ->modalWidth('sm')
                        ->action(function (array $data, Model $record) {
                            $record->update(['balance' => $record->balance + $data['balance']]);
                            Notification::make()
                                ->title('Thành công')
                                ->body('Thêm số dư thành công')
                                ->success()
                                ->send();
                        }),
                    // trừ balance
                    Tables\Actions\Action::make('sub_balance')
                        ->label('Trừ số dư')
                        ->icon('heroicon-o-minus')
                        ->form([
                            TextInput::make('balance')
                                ->label('Số dư')
                                ->numeric()
                                ->required(),
                        ])
                        ->modalWidth('sm')
                        ->action(function (array $data, Model $record) {
                            $record->update(['balance' => $record->balance - $data['balance']]);
                            Notification::make()
                                ->title('Thành công')
                                ->body('Trừ số dư thành công')
                                ->success()
                                ->send();
                        }),
                    //thêm só dư đóng băng
                    Tables\Actions\Action::make('add_balance_deposit')
                        ->label('Thêm số dư đóng băng')
                        ->icon('heroicon-o-plus')
                        ->form([
                            TextInput::make('balance_lock')
                                ->label('Số dư đóng băng')
                                ->numeric()
                                ->required(),
                        ])
                        ->modalWidth('sm')
                        ->action(function (array $data, Model $record) {
                            $record->update(['balance_lock' => $record->balance_lock + $data['balance_lock']]);
                            Notification::make()
                                ->title('Thành công')
                                ->body('Thêm số dư đóng băng thành công')
                                ->success()
                                ->send();
                        }),
                    //trừ số dư đóng băng
                    Tables\Actions\Action::make('sub_balance_deposit')
                        ->label('Trừ số dư đóng băng')
                        ->icon('heroicon-o-minus')
                        ->form([
                            TextInput::make('balance_lock')
                                ->label('Số dư đóng băng')
                                ->numeric()
                                ->required(),
                        ])
                        ->modalWidth('sm')
                        ->action(function (array $data, Model $record) {
                            $record->update(['balance_lock' => $record->balance_lock - $data['balance_lock']]);
                            Notification::make()
                                ->title('Thành công')
                                ->body('Trừ số dư đóng băng thành công')
                                ->success()
                                ->send();
                        }),

                    // change password2
                    Tables\Actions\Action::make('change_password2')
                        ->label('Đổi mật khẩu vốn')
                        ->icon('heroicon-o-key')
                        ->form([
                            TextInput::make('password2')
                                ->label('Mật khẩu vốn')
                                ->password()
                                ->required(),
                        ])
                        ->modalWidth('sm')
                        ->action(function (array $data, Model $record) {
                            $record->update(['password2' => $data['password2']]);
                            Notification::make()
                                ->title('Thành công')
                                ->body('Đổi mật khẩu vốn thành công')
                                ->success()
                                ->send();
                        }),
                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
