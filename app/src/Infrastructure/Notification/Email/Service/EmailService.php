<?php
declare(strict_types=1);

namespace App\Infrastructure\Notification\Email\Service;

use App\Infrastructure\Notification\Email\MailerInterface;
use App\Infrastructure\Notification\NotificationInterface;
use Exception;
use RuntimeException;

class EmailService implements NotificationInterface
{
    private $mailer;
    private $recipients;

    private const SUBJECT = 'Notification';
    private const FROM = 'app@email.com';

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;

        // Should add logic to define recipients
        $this->recipients = [];
    }

    public function send(string $message): void
    {
        try {

            $this->mailer->send(self::FROM, $this->recipients, self::SUBJECT, $message);

        } catch (Exception $e) {
            throw new RuntimeException('Could not send email');
        }
    }
}
