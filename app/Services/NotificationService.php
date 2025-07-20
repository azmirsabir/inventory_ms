<?php

namespace App\Services;

use App\Services\Interface\INotificationService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
class NotificationService implements INotificationService
{
    public function sendSlackNotification(Collection $data, string $slackUrl, string $notificationClass): void
    {
      Notification::route('slack', $slackUrl)
        ->notify(new $notificationClass($data));
    }
    
    public function sendEmailNotification(string|array $email, mixed $data, string $notificationClass): void
    {
      Mail::to($email)->send(new $notificationClass($data));
    }
}
