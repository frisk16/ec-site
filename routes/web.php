<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\VerifyTokenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// TOPページ
Route::get('/', [HomeController::class, 'index'])->name('home');


Auth::routes(['verify' => true]);

// 確認メール再送信
Route::post('/email/verification-notification', function(Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('success_msg', '確認メールを再送信しました、ご確認ください');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// パスワード再設定手続き完了ページ
Route::get('/password/reset_complete', [HomeController::class, 'reset_complete'])
    ->middleware(['auth', 'verified'])
    ->name('password.reset_complete');

// マイページ関連
Route::controller(UserController::class)->middleware(['auth', 'verified'])
    ->group(function() {
        Route::get('mypage/edit_info', 'edit_info')->name('mypage.edit_info');
        Route::put('mypage/edit_info', 'update_info')->name('mypage.update_info');
        Route::get('mypage/edit_password', 'edit_password')->name('mypage.edit_password');
        Route::put('mypage/edit_password', 'update_password')->name('mypage.update_password');
    });

// クレジットカード関連
Route::controller(CustomerController::class)->middleware(['auth', 'verified'])
    ->group(function() {
        Route::get('mypage/credit_card', 'index')->name('customers.index');
        Route::post('mypage/credit_card', 'store')->name('customers.store');
        Route::put('mypage/credit_card/{customer}', 'update_enabled')->name('customers.update_enabled');
        Route::delete('mypage/credit_card/{customer}', 'destroy')->name('customers.destroy');
    });

// 有料会員登録(定期支払い)関連
Route::controller(SubscriptionController::class)->middleware(['auth', 'verified'])
    ->group(function() {
        Route::get('mypage/subscription', 'index')->name('subscriptions.index');
        Route::post('mypage/subscription', 'register')->name('subscriptions.register');
        Route::get('mypage/subscription_complete', 'complete')->name('subscriptions.complete');
    });

// パスワード＆トークン検証関連
Route::controller(VerifyTokenController::class)->middleware(['auth', 'verified'])
    ->group(function() {
        Route::get('verify', 'index')->name('verify.index');
        Route::post('verify', 'verify_token')->name('verify.token');
        Route::get('verify/token_error', 'token_error')->name('verify.token_error');
    });

