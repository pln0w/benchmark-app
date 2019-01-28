<?php

namespace App\Application\EventSubscriber\Benchmark;

use App\Domain\Benchmark\Event\WebsiteLoadedSlowerEvent;
use App\Domain\Benchmark\Event\WebsiteLoadedSlowerTwiceEvent;
use App\Infrastructure\Notification\Email\Service\EmailService;
use App\Infrastructure\Notification\Sms\Service\SmsService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class WebsiteLoadedSlowerEventSubscriber implements EventSubscriberInterface
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
            WebsiteLoadedSlowerEvent::NAME      => 'onWebsiteLoadedSlower',
            WebsiteLoadedSlowerTwiceEvent::NAME => 'onWebsiteLoadedSlowerTwice',
        ];
    }

    public function onWebsiteLoadedSlower(WebsiteLoadedSlowerEvent $event): void
    {
        print("\n==> EVENT::onWebsiteLoadedSlower fired.\n");

        $siteUrl = $event->getReportData()->getWebsiteResult()->getWebsite()->getUrl();
        $message = "The $siteUrl website loaded slower than at least one competitor website.";

        $this->emailService->send($message);
    }

    public function onWebsiteLoadedSlowerTwice(WebsiteLoadedSlowerTwiceEvent $event): void
    {
        print("\n==> EVENT::onWebsiteLoadedSlowerTwice fired.\n");

        $siteUrl = $event->getReportData()->getWebsiteResult()->getWebsite()->getUrl();
        $message = "The $siteUrl website loaded slower twice than at least one competitor website.";

        $this->smsService->send($message);
    }
}
