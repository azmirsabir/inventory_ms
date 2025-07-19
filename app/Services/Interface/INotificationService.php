<?php

namespace App\Services\Interface;

use Illuminate\Support\Collection;

interface INotificationService
{
    public function sendSlackNotification(Collection $data, string $slackUrl, string $notificationClass): void;
    public function sendEmailNotification(string|array $email, mixed $data, string $notificationClass): void;
}
