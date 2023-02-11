<?php

namespace Magical\Payment;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/payment.php', 'payment'
        );

        $this->app->bind('payment', function ($app) {
            return new Payment();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Config
        $this->publishes([
            __DIR__.'/../config/payment.php' => config_path('payment.php'),
        ], 'config');

        // Export configuration file
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/payment.php' => config_path('payment.php'),
            ], 'config');
        }

        // Routes
        Route::group(['middleware' => 'web'], fn () => $this->loadRoutesFrom(__DIR__.'/../routes/web.php'));

        // Views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'payment');

        // Publish assets
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('payment'),
        ], 'assets');
    }
}
