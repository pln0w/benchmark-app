<?php

namespace App\Infrastructure\Notification\Sms\Service;

use App\Infrastructure\Notification\Sms\MailerInterface;
use App\Infrastructure\Notification\NotificationInterface;
use App\Infrastructure\Notification\Sms\SmsGatewayInterface;

final class SmsService implements NotificationInterface
{
    private $gateway;
    private $recipients;

    /*
     * Pass any adapter implements SmsGatewayInterface
     */
    public function __construct(SmsGatewayInterface $gateway)
    {
        $this->gateway = $gateway;

        /*
         * These details obviously can be passed from container parameters
         * (i.e taken from env or passed through the Config class object)
         */
        $this->recipients = [];
        $this->recipients[] = '088111222333';
    }

    public function send(string $message): void
    {
        $this->gateway->send($this->recipients, $message);
    }
}
