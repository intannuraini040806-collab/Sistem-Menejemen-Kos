<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserActivityNotification extends Notification
{
    use Queueable;

    public function __construct(protected array $notificationData) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return array_merge([
            'title' => 'Informasi KosHaven',
            'message' => '',
            'type' => 'info',
            'icon' => 'bi-bell',
            'url' => route('penghuni.dashboard'),
        ], $this->notificationData);
    }
}
