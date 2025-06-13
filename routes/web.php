<?php
declare(strict_types=1);

use App\Http\Controllers\AccountController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserSubscriptionController;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => [UserMiddleware::class]], static function () {
    Route::get('/', [SubscriptionController::class, 'index'])->name('subscriptions.index');

    Route::get('/account', [AccountController::class, 'show'])->name('account');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');

    Route::resource('subscriptions', SubscriptionController::class)->parameter('subscriptions', 'id')->except([
        'index',
    ]);
    Route::post('subscriptions/{id}/subscribe', [SubscriptionController::class, 'subscribe'])
        ->name('subscriptions.subscribe');
    Route::post('subscriptions/{id}/unsubscribe', [SubscriptionController::class, 'unsubscribe'])
        ->name('subscriptions.unsubscribe');

    Route::get('user-subscriptions', [UserSubscriptionController::class, 'index'])->name('user-subscriptions.index');
});
