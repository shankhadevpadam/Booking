<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse
        {
            public function toResponse($request)
            {
                activity('auth')
                    ->withProperties(['ip' => request()->ip()])
                    ->log(Auth::user()->name.' login the system with ip address '.request()->ip().' at '.now());

                return match (Auth::check()) {
                    Auth::user()->is_admin === 1 => redirect()->route('admin.home'),
                    Auth::user()->is_admin === 0 && Auth::user()->hasRole('Vendor') => redirect()->route('vendor.home'),
                    default => redirect()->intended(config('fortify.home'))
                };
            }
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });

        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);

        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);

        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
    }
}
