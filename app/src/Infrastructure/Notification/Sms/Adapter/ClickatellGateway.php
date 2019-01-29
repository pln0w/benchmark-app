<?php

namespace App\Infrastructure\Notification\Sms\Adapter;

use App\Infrastructure\Notification\Sms\SmsGatewayInterface;

final class ClickatellGateway implements SmsGatewayInterface
{
    public function send(array $recipients, string $body): void
    {
        // mock

        printf('%s', $body.PHP_EOL);
        printf('%s', 'SMS sent via Clickatell gateway.'.PHP_EOL);
    }
}
