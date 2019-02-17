<?php
declare(strict_types=1);

namespace App\Infrastructure\Notification\Email;

interface MailerInterface
{
    public function send(string $from, array $recipients, string $subject, string $body): void;
}
