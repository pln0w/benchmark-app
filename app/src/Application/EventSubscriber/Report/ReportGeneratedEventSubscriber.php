<?php
declare(strict_types=1);

namespace App\Application\EventSubscriber\Report;

use App\Domain\Report\Event\ReportGeneratedEvent;
use App\Infrastructure\Notification\Email\Service\EmailService;
use App\Infrastructure\Notification\Sms\Service\SmsService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ReportGeneratedEventSubscriber implements EventSubscriberInterface
{
    private $emailService;
    private $smsService;

    public function __construct(
        EmailService $emailService,
        SmsService $smsService
    ) {
        $this->emailService = $emailService;
        $this->smsService = $smsService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ReportGeneratedEvent::NAME => 'onReportGenerated',
        ];
    }

    public function onReportGenerated(ReportGeneratedEvent $event): void
    {
        if ($event->getReportData()->isWebsiteResultSlower()) {
            $siteUrl = $event->getReportData()->getWebsiteResult()->getWebsite()->getUrl();
            $message = "\nThe $siteUrl website loaded slower than at least one competitor website.";

            $this->emailService->send($message);
        }

        if ($event->getReportData()->isWebsiteResultSlowerTwice()) {
            $siteUrl = $event->getReportData()->getWebsiteResult()->getWebsite()->getUrl();
            $message = "\nThe $siteUrl website loaded slower twice than at least one competitor website.";

            $this->smsService->send($message);
        }
    }
}
