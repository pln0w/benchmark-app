<?php

namespace App\Infrastructure\Notification\Sms;

interface SmsGatewayInterface
{
    public function send(array $recipients, string $body): void;
}
