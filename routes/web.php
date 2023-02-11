<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::get('/send-email', function () {
    \Illuminate\Support\Facades\Mail::raw('Test Email', function ($message) {
        $message->to('shankhadev123@gmail.com');
    });

    $user = App\Models\User::find(1);

    $user->notify(new App\Notifications\TestNotification());
});

Route::prefix('guide')
    ->name('guide.')
    ->group(function () {
        Route::get('/register', function () {
            return view('auth.guide-register');
        })->name('register');

        Route::controller(App\Http\Controllers\Auth\GuideRegisterController::class)
            ->group(function () {
                Route::post('/register', 'store')->name('store');
                Route::get('/approval/{id}', 'approval')->name('approval');
            });
    });

Route::middleware(['auth', 'user'])
    ->group(function () {
        Route::get('/home', [App\Http\Controllers\User\HomeController::class, 'index'])->name('home');

        Route::singleton('/profile', App\Http\Controllers\User\ProfileController::class);

        Route::get('/package/departure/{id}', App\Http\Controllers\User\PackageDepartureController::class)->name('package.departure');

        Route::controller(App\Http\Controllers\User\BookingController::class)
            ->prefix('booking')
            ->name('booking.')
            ->group(function () {
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/success', 'success')->name('success');
            });

        Route::get('/invoice/{userPackagePayment}/view', App\Http\Controllers\User\InvoiceController::class)->name('invoice');

        Route::resource('/reviews', App\Http\Controllers\User\ReviewController::class)->only(['create', 'store']);
    });

// Routes for vendor
Route::prefix('vendor')
    ->name('vendor.')
    ->middleware(['auth', 'role:Vendor'])
    ->group(function () {
        Route::get('/home', [App\Http\Controllers\Vendor\HomeController::class, 'index'])->name('home');
    });

require __DIR__ . '/payment.php';
