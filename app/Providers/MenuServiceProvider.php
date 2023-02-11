<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            if (auth()->user()->is_admin === false) {
                $event->menu->remove('admin_home');

                $event->menu->add([
                    'text' => 'Home',
                    'key' => 'user_home',
                    'route' => 'home',
                    'icon' => 'nav-icon fas fa-house-user',
                ]);
            }
        });
    }
}
