<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserRegisteredNotification extends Notification
{
    public $newUser;

    public function __construct($newUser)
    {
        $this->newUser = $newUser;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('person.New User Registration'))
            ->line(__('person.A new user has registered:'))
            ->line(__('person.Name:') . $this->newUser->name)
            ->line(__('person.Email:') . $this->newUser->email)
            ->action(__('person.View User'), url('/admin/users/' . $this->newUser->id))
            ->line(__('person.Thank you for using our application!'));
    }
}

