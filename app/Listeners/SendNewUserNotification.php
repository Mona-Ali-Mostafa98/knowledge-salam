<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Notifications\NewUserRegisteredNotification;

class SendNewUserNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(\Illuminate\Auth\Events\Registered $event)
    {
        $newUser = $event->user;

        User::role('super_admin')->each(function ($admin) use ($newUser) {
            $admin->notify(new NewUserRegisteredNotification($newUser));
        });
    }
}
