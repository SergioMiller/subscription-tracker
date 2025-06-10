<?php
declare(strict_types=1);

use App\Http\Controllers\AccountController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
})->name('welcome');

Route::group(['middleware' => [UserMiddleware::class]], static function () {
    Route::get('/account', [AccountController::class, 'show'])->name('account');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');

    Route::resource('subscriptions', SubscriptionController::class)->parameter('subscriptions', 'id');
});
