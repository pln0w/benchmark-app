<?php

namespace App\Infrastructure\Notification\Email\Service;

use App\Infrastructure\Notification\Email\MailerInterface;
use App\Infrastructure\Notification\NotificationInterface;

final class EmailService implements NotificationInterface
{
    private $mailer;
    private $subject;
    private $from;
    private $recipients;

    /*
     * Pass any adapter implements MailerInterface
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;

        /*
         * These details obviously can be passed from container parameters
         * (i.e taken from env or passed through the Config class object)
         */
        $this->subject = 'Notification';
        $this->from = 'app@email.com';
        $this->recipients = [];
        $this->recipients[] = 'notify@mail.com';
    }

    public function send(string $message): void
    {
        $this->mailer->send($this->from, $this->recipients, $this->subject, $message);
    }
}
