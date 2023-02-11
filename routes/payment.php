<?php

use Illuminate\Support\Facades\Route;

Route::get('/payment', App\Http\Controllers\Payment\PaymentController::class)->name('payment');

Route::controller(App\Http\Controllers\Payment\PayPalController::class)
    ->prefix('paypal')
    ->name('paypal.')
    ->group(function () {
        Route::get('/payment/return', 'return')->name('payment.return');
        Route::get('/payment/cancel', 'cancel')->name('payment.cancel');
    });

/* Route::controller(App\Http\Controllers\Payment\HblController::class)
    ->prefix('hbl')
    ->name('hbl.')
    ->group(function () {
        Route::get('/payment/{payment_id?}', 'payment')->name('payment');
        Route::post('/payment/success', 'success')->name('payment.success');
        Route::post('/payment/cancel', 'cancel')->name('payment.cancel');
    });

Route::controller(App\Http\Controllers\Payment\NicAsiaController::class)
    ->prefix('nicasia')
    ->name('nicasia.')
    //->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->group(function () {
        Route::get('/payment/success', 'success')->name('payment.success');
        Route::get('/payment/cancel', 'cancel')->name('payment.cancel');
        Route::get('/payment/{payment_id?}', 'payment')->name('payment.return');
    }); */
