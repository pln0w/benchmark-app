<?php

namespace App\Infrastructure\Notification;

interface NotificationInterface
{
    public function send(string $message): void;
}
