<?php

namespace App\Listeners;

use App\Events\Registered;
use App\Models\User;
use App\Notifications\NewUserRegistrationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminNewUserRegistrationNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  NewUserRegistration  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $admin = User::role('Super Admin')->first();

        $admin->notify(new NewUserRegistrationNotification($event->user));
    }
}
