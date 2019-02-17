<?php
declare(strict_types=1);

namespace App\Infrastructure\Notification\Sms\Service;

use App\Infrastructure\Notification\NotificationInterface;
use App\Infrastructure\Notification\Sms\MailerInterface;
use App\Infrastructure\Notification\Sms\SmsGatewayInterface;
use Exception;
use RuntimeException;

class SmsService implements NotificationInterface
{
    private $gateway;
    private $recipients;

    public function __construct(SmsGatewayInterface $gateway)
    {
        $this->gateway = $gateway;

        // Should add logic to define recipients
        $this->recipients = [];
    }

    public function send(string $message): void
    {
        try {

            $this->gateway->send($this->recipients, $message);

        } catch (Exception $e) {
            throw new RuntimeException('Could not send SMS');
        }
    }
}
