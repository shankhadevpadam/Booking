<?php

use Illuminate\Support\Facades\Route;

Route::prefix('paypal')
    ->name('paypal.')
    ->group(function () {
        Route::get('/payment/success', [\Magical\Payment\Http\Controllers\PayPalController::class, 'success'])->name('success');

        Route::get('/payment/cancel', [\Magical\Payment\Http\Controllers\PayPalController::class, 'cancel'])->name('cancel');
    });

Route::prefix('hbl')
    ->name('hbl.')
    ->group(function () {
        Route::get('/payment/{payment_id?}', [\Magical\Payment\Http\Controllers\HblController::class, 'payment'])->name('payment');
        Route::post('/payment/success', [\Magical\Payment\Http\Controllers\HblController::class, 'success'])->name('success');
        Route::post('/payment/cancel', [\Magical\Payment\Http\Controllers\HblController::class, 'cancel'])->name('cancel');
    });

Route::prefix('nicasia')
    ->name('nicasia.')
    ->group(function () {
        Route::get('/payment/{payment_id?}', [\Magical\Payment\Http\Controllers\NicAsiaController::class, 'payment'])->name('payment');
        Route::post('/payment/success', [\Magical\Payment\Http\Controllers\NicAsiaController::class, 'success'])->name('success')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        Route::get('/payment/cancel', [\Magical\Payment\Http\Controllers\NicAsiaController::class, 'cancel'])->name('cancel');
    });
