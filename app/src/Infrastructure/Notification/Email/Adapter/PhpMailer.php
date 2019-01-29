<?php

namespace App\Infrastructure\Notification\Email\Adapter;

use App\Infrastructure\Notification\Email\MailerInterface;

final class PhpMailer implements MailerInterface
{
    public function send(string $from, array $recipients, string $subject, string $body): void
    {
        // mock

        printf('%s', $body.PHP_EOL);
        printf('%s', 'Email sent via PhpMailer.'.PHP_EOL);
    }
}
