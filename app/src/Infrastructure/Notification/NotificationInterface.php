<?php
declare(strict_types=1);

namespace App\Infrastructure\Notification;

interface NotificationInterface
{
    public function send(string $message): void;
}
