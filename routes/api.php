<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')
    ->group(function () {
        Route::controller(App\Http\Controllers\Api\V1\Package\PackageController::class)
            ->prefix('packages')
            ->group(function () {
                Route::get('/', 'index');
                Route::get('/{slug}', 'review');
                Route::get('/{package:slug}/departures', 'departures');
                Route::get('/{package:slug}/dates', 'dates');
                Route::get('/{id}/group-discount', 'groupPrice');
                Route::get('/departures/{departure}', 'departureById');
                Route::get('/addons/{packageId}', 'addonPackages');
            });

        Route::controller(App\Http\Controllers\Api\V1\Booking\BookingController::class)
            ->prefix('booking')
            ->group(function () {
                Route::get('/booker', 'booker');
                Route::post('/payment', 'payment');
                Route::post('/dates', 'dates');
                Route::post('/complete', 'complete');
                Route::post('/payment-intent', 'paymentIntent');
                Route::get('/{id}/confirmation', 'confirmation');
            });

        Route::controller(App\Http\Controllers\Api\V1\Review\ReviewController::class)
            ->prefix('reviews')
            ->group(function () {
                Route::get('/popular-reviews', 'popular');
                Route::get('/{package:slug}', 'package');
            });

        Route::controller(App\Http\Controllers\Api\V1\Setting\SettingController::class)
            ->prefix('settings')
            ->group(function () {
                Route::get('/payment', 'payment');
                Route::get('/common', 'common');
            });

        Route::get('/coupons/check', [App\Http\Controllers\Api\V1\Coupon\CouponController::class, 'check']);
        Route::get('/countries', [App\Http\Controllers\Api\V1\Country\CountryController::class, 'index']);
    });
