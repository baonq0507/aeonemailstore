<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\HomeController;
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['lang'])->group(function () {
    Route::get('/login', [AuthController::class, 'showFormLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'showFormRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::middleware(['auth'])->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/order', [HomeController::class, 'history'])->name('order.index');
        Route::get('/user', [HomeController::class, 'user'])->name('user.index');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/mission', [HomeController::class, 'mission'])->name('mission.index');
        Route::post('/mission/start', [HomeController::class, 'missionStart'])->name('mission.start');
        Route::get('/deposit', [HomeController::class, 'deposit'])->name('deposit.index');
        Route::post('/deposit', [HomeController::class, 'depositStore'])->name('deposit.store');
        Route::get('/withdraw', [HomeController::class, 'withdraw'])->name('withdraw.index');
        Route::post('/withdraw', [HomeController::class, 'withdrawStore'])->name('withdraw.store');
        Route::get('/giaodich', [HomeController::class, 'giaodich'])->name('giaodich.index');
        Route::get('/password', [HomeController::class, 'password'])->name('password.index');
        Route::post('/password', [HomeController::class, 'passwordChange'])->name('password2.change');
        Route::get('/bank', [HomeController::class, 'bank'])->name('bank.index');
        Route::post('/bank', [HomeController::class, 'bankStore'])->name('bank.store');
        Route::get('/level', [HomeController::class, 'level'])->name('level.index');
        Route::get('/address', [HomeController::class, 'address'])->name('address.index');
        Route::post('/address', [HomeController::class, 'addressStore'])->name('address.store');
        Route::post('/product/buy', [HomeController::class, 'productBuy'])->name('product.buy');
        Route::get('/feedback', [HomeController::class, 'feedback'])->name('feedback.index');

    });
});

Route::get('/change-lang', [LangController::class, 'changeLang'])->name('changeLang');
