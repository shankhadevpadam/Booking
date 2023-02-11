<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])
            ->middleware('guide.approval')
            ->name('home');

        Route::controller(App\Http\Controllers\Admin\HomeController::class)
            ->group(function () {
                Route::get('/clients/package/datatable', 'dataTable')->name('clients.package.datatable');
                Route::get('/approval', 'approval')->name('guide.approval');
                Route::get('/clients/package/delete/{userPackage}', 'destroyUserPackageDeparture')->name('clients.package.departure.delete');
                Route::post('/clients/package/departure/delete_selected', 'destroySelectedUserPackageDeparture')->name('clients.package.departure.delete_selected');
                Route::post('/clients/package/departure/delete_selected_permanently', 'destroySelectedUserPackageDeparturePermanently')->name('clients.package.departure.delete_selected_permanently');
                Route::post('/clients/package/departure/restore', 'restoreUserPackageDeparture')->name('clients.package.departure.restore');
            });

        Route::post('/delete/media', App\Actions\Media\DeleteMedia::class)->name('delete.media');

        Route::get('/invoice/{userPackagePayment}/view', App\Http\Controllers\Admin\Invoice\InvoiceController::class)->name('invoice');

        Route::controller(App\Http\Controllers\Admin\User\ClientController::class)
            ->prefix('clients')
            ->name('clients.')
            ->group(function () {
                Route::get('/package/{userPackage}', 'show')->name('package.show');
                Route::get('/datatable', 'dataTable')->name('datatable');
                Route::get('/delete/{user}', 'destroy')->name('delete');
                Route::post('/delete_selected', 'destroySelected')->name('delete_selected');
                Route::post('/delete_selected_permanently', 'destroySelectedPermanently')->name('delete_selected_permanently');
                Route::get('/delete_completely', 'destroyCompletely')->name('delete_completely');
                Route::post('/restore', 'restore')->name('restore');
            });
        Route::resource('clients', App\Http\Controllers\Admin\User\ClientController::class);

        Route::controller(App\Http\Controllers\Admin\Coupon\CouponController::class)
            ->prefix('coupons')
            ->name('coupons.')
            ->group(function () {
                Route::get('/datatable', 'dataTable')->name('datatable');
                Route::get('/delete/{coupon}', 'destroy')->name('delete');
                Route::post('/delete_selected', 'destroySelected')->name('delete_selected');
                Route::get('/delete_completely', 'destroyCompletely')->name('delete_completely');
            });
        Route::resource('coupons', App\Http\Controllers\Admin\Coupon\CouponController::class);

        Route::prefix('incomes')
            ->name('incomes.')
            ->group(function () {
                Route::get('/datatable', [App\Http\Controllers\Admin\Account\IncomeController::class, 'dataTable'])->name('datatable');
            });
        Route::resource('incomes', App\Http\Controllers\Admin\Account\IncomeController::class)->only(['index']);

        Route::resource('expenses', App\Http\Controllers\Admin\Account\ExpenseController::class)->only(['index']);

        Route::controller(App\Http\Controllers\Admin\Payment\BankController::class)
            ->prefix('banks')
            ->name('banks.')
            ->group(function () {
                Route::get('/datatable', 'dataTable')->name('datatable');
                Route::get('/delete/{bank}', 'destroy')->name('delete');
                Route::post('/delete_selected', 'destroySelected')->name('delete_selected');
                Route::get('/delete_completely', 'destroyCompletely')->name('delete_completely');
            });
        Route::resource('banks', App\Http\Controllers\Admin\Payment\BankController::class);

        Route::controller(App\Http\Controllers\Admin\Payment\CurrencyController::class)
            ->prefix('currencies')
            ->name('currencies.')
            ->group(function () {
                Route::get('/datatable', 'dataTable')->name('datatable');
                Route::get('/delete/{currency}', 'destroy')->name('delete');
                Route::post('/delete_selected', 'destroySelected')->name('delete_selected');
                Route::get('/delete_completely', 'destroyCompletely')->name('delete_completely');
            });
        Route::resource('currencies', App\Http\Controllers\Admin\Payment\CurrencyController::class);

        Route::controller(App\Http\Controllers\Admin\Review\ReviewController::class)
            ->prefix('reviews')
            ->name('reviews.')
            ->group(function () {
                Route::get('/datatable', 'dataTable')->name('datatable');
                Route::get('/delete/{id}', 'destroy')->name('delete');
                Route::post('/delete_selected', 'destroySelected')->name('delete_selected');
                Route::get('/delete_completely', 'destroyCompletely')->name('delete_completely');
            });
        Route::resource('reviews', App\Http\Controllers\Admin\Review\ReviewController::class);

        Route::controller(App\Http\Controllers\Admin\Transportation\LocationController::class)
            ->prefix('locations')
            ->name('locations.')
            ->group(function () {
                Route::get('/datatable', 'dataTable')->name('datatable');
                Route::get('/delete/{location}', 'destroy')->name('delete');
                Route::post('/delete_selected', 'destroySelected')->name('delete_selected');
                Route::get('/delete_completely', 'destroyCompletely')->name('delete_completely');
            });
        Route::resource('locations', App\Http\Controllers\Admin\Transportation\LocationController::class);

        Route::controller(App\Http\Controllers\Admin\Transportation\AirlineController::class)
            ->prefix('airlines')
            ->name('airlines.')
            ->group(function () {
                Route::get('/datatable', 'dataTable')->name('datatable');
                Route::get('/delete/{airline}', 'destroy')->name('delete');
                Route::post('/delete_selected', 'destroySelected')->name('delete_selected');
                Route::get('/delete_completely', 'destroyCompletely')->name('delete_completely');
            });
        Route::resource('airlines', App\Http\Controllers\Admin\Transportation\AirlineController::class);

        Route::controller(App\Http\Controllers\Admin\Package\PackageController::class)
            ->prefix('packages')
            ->name('packages.')
            ->group(function () {
                Route::get('/datatable', 'dataTable')->name('datatable');
                Route::get('/delete/{package}', 'destroy')->name('delete');
                Route::post('/delete_selected', 'destroySelected')->name('delete_selected');
                Route::post('/delete_selected_permanently', 'destroySelectedPermanently')->name('delete_selected_permanently');
                Route::get('/delete_completely', 'destroyCompletely')->name('delete_completely');
                Route::post('/restore', 'restore')->name('restore');

                Route::prefix('{package}')
                    ->group(function () {
                        Route::controller(App\Http\Controllers\Admin\Package\PackageDepartureController::class)
                            ->group(function () {
                                Route::get('/departures/datatable', 'dataTable')->name('departures.datatable');
                                Route::get('/departures/delete/{departure}', 'destroy')->name('departures.delete');
                                Route::post('/delete_selected_permanently', 'destroySelectedPermanently')->name('departures.delete_selected_permanently');
                                Route::post('/departures/delete_selected', 'destroySelected')->name('departures.delete_selected');
                                Route::get('/departures/delete_completely', 'destroyCompletely')->name('departures.delete_completely');
                                Route::post('/restore', 'restore')->name('departures.restore');
                            });
                        Route::resource('departures', App\Http\Controllers\Admin\Package\PackageDepartureController::class);

                        Route::controller(App\Http\Controllers\Admin\Package\PackageAddonController::class)
                            ->group(function () {
                                Route::get('/addons/datatable', 'dataTable')->name('addons.datatable');
                                Route::get('/addons/delete/{addon}', 'destroy')->name('addons.delete');
                            });
                        Route::resource('addons', App\Http\Controllers\Admin\Package\PackageAddonController::class);

                        Route::controller(App\Http\Controllers\Admin\Package\PackageGroupDiscountController::class)
                            ->group(function () {
                                Route::get('/discounts/datatable', 'dataTable')->name('discounts.datatable');
                                Route::get('/discounts/delete/{discount}', 'destroy')->name('discounts.delete');
                            });
                        Route::resource('discounts', App\Http\Controllers\Admin\Package\PackageGroupDiscountController::class);

                        Route::controller(App\Http\Controllers\Admin\Package\PackageExpensesController::class)
                            ->group(function () {
                                Route::get('/expenses/datatable', 'dataTable')->name('expenses.datatable');
                                Route::get('/expenses/delete/{discount}', 'destroy')->name('expenses.delete');
                            });
                        Route::resource('expenses', App\Http\Controllers\Admin\Package\PackageExpensesController::class);
                    });
            });
        Route::resource('packages', App\Http\Controllers\Admin\Package\PackageController::class);

        Route::prefix('settings')
            ->name('settings.')
            ->group(function () {
                Route::controller(App\Http\Controllers\Admin\Setting\GeneralSettingController::class)
                    ->group(function () {
                        Route::get('/general', 'index')->name('general');
                        Route::post('/general/update', 'update')->name('general.update');
                    });

                Route::controller(App\Http\Controllers\Admin\Setting\UserEmailSettingController::class)
                    ->group(function () {
                        Route::get('/user-email-notifications', 'index')->name('user.email');
                        Route::post('/user-email-notifications/update', 'update')->name('user.email.update');
                    });

                Route::controller(App\Http\Controllers\Admin\Setting\GuideEmailSettingController::class)
                    ->group(function () {
                        Route::get('/guide-email-notifications', 'index')->name('guide.email');
                        Route::post('/guide-email-notifications/update', 'update')->name('guide.email.update');
                    });

                Route::controller(App\Http\Controllers\Admin\Setting\CronEmailSettingController::class)
                    ->group(function () {
                        Route::get('/cron-email-notifications', 'index')->name('cron.email');
                        Route::post('/cron-email-notifications/update', 'update')->name('cron.email.update');
                    });

                Route::controller(App\Http\Controllers\Admin\Setting\AdminEmailSettingController::class)
                    ->group(function () {
                        Route::get('/admin-email-notifications', 'index')->name('admin.email');
                        Route::post('/admin-email-notifications/update', 'update')->name('admin.email.update');
                    });
            });

        Route::controller(App\Http\Controllers\Admin\User\UserController::class)
            ->prefix('users')
            ->name('users.')
            ->group(function () {
                Route::get('/datatable', 'dataTable')->name('datatable');
                Route::get('/delete/{user}', 'destroy')->name('delete');
                Route::post('/delete_selected', 'destroySelected')->name('delete_selected');
                Route::post('/delete_selected_permanently', 'destroySelectedPermanently')->name('delete_selected_permanently');
                Route::get('/delete_completely', 'destroyCompletely')->name('delete_completely');
                Route::post('/restore', 'restore')->name('restore');
                Route::get('/users', 'getUsers')->name('users');
            });
        Route::resource('users', App\Http\Controllers\Admin\User\UserController::class);

        Route::controller(App\Http\Controllers\Admin\Booking\BookingController::class)
            ->prefix('booking')
            ->name('booking.')
            ->group(function () {
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/success', 'success')->name('success');
            });

        Route::controller(App\Http\Controllers\Admin\User\GuideController::class)
            ->prefix('guides')
            ->name('guides.')
            ->group(function () {
                Route::get('/datatable', 'dataTable')->name('datatable');
                Route::get('/delete/{guide}', 'destroy')->name('delete');
                Route::post('/delete_selected', 'destroySelected')->name('delete_selected');
                Route::post('/delete_selected_permanently', 'destroySelectedPermanently')->name('delete_selected_permanently');
                Route::get('/delete_completely', 'destroyCompletely')->name('delete_completely');
                Route::post('/restore', 'restore')->name('restore');
                Route::post('/approve', 'approve')->name('approve');
            });
        Route::resource('guides', App\Http\Controllers\Admin\User\GuideController::class);

        Route::controller(App\Http\Controllers\Admin\User\VendorController::class)
            ->prefix('vendors')
            ->name('vendors.')
            ->group(function () {
                Route::get('/datatable', 'dataTable')->name('datatable');
                Route::get('/delete/{vendor}', 'destroy')->name('delete');
                Route::post('/delete_selected', 'destroySelected')->name('delete_selected');
                Route::get('/delete_completely', 'destroyCompletely')->name('delete_completely');
            });
        Route::resource('vendors', App\Http\Controllers\Admin\User\VendorController::class);

        Route::singleton('/profile', App\Http\Controllers\Admin\User\ProfileController::class)
            ->middleware('guide.approval');

        Route::resource('roles', App\Http\Controllers\Admin\Role\RoleController::class);
    });
