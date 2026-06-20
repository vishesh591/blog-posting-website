<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Welcome aboard',
            'message' => 'Your publisher account is ready. Start writing, curating, and sharing ideas.',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to InkPress')
            ->greeting('Welcome, '.$notifiable->name)
            ->line('Your workspace is ready.')
            ->action('Open dashboard', route('dashboard.index'));
    }
}
