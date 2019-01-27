<?php

namespace App\Infrastructure\Notification\Email\Adapter;

use App\Infrastructure\Notification\Email\MailerInterface;

final class SwiftMailer implements MailerInterface
{
    public function send(string $from, array $recipients, string $subject, string $body): void
    {
        echo 'Email sent via SwiftMailer.';
    }
}
