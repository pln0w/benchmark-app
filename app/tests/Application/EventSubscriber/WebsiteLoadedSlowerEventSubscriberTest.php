<?php

namespace Tests\Application\EventSubscriber;

use App\Application\EventSubscriber\Benchmark\WebsiteLoadedSlowerEventSubscriber;
use App\Domain\Benchmark\Event\WebsiteLoadedSlowerEvent;
use App\Domain\Benchmark\Event\WebsiteLoadedSlowerTwiceEvent;
use App\Domain\Benchmark\ValueObject\Result;
use App\Domain\Report\ValueObject\ReportData;
use App\Domain\Url\ValueObject\Url;
use App\Infrastructure\Notification\Email\Adapter\SwiftMailer;
use App\Infrastructure\Notification\Email\Service\EmailService;
use App\Infrastructure\Notification\Sms\Adapter\ClickatellGateway;
use App\Infrastructure\Notification\Sms\Service\SmsService;
use Mockery;
use PHPUnit\Framework\TestCase;

class WebsiteLoadedSlowerEventSubscriberTest extends TestCase
{
    public function testIsSubscribed(): void
    {
        $this->assertTrue(0 < count(WebsiteLoadedSlowerEventSubscriber::getSubscribedEvents()));
    }

    public function testOnWebsiteLoadedSlower(): void
    {
        $mailService = new EmailService(new SwiftMailer());
        $smsService = new SmsService(new ClickatellGateway());

        $subscriber = new WebsiteLoadedSlowerEventSubscriber(
            $mailService,
            $smsService
        );

        $mEvent = Mockery::mock(WebsiteLoadedSlowerEvent::class);
        $mEvent->expects('getReportData')->andReturnUsing(function () {

            $mReportData = Mockery::mock(ReportData::class);
            $mReportData->expects('getWebsiteResult')
                        ->andReturnUsing(function () {

                            $mResult = Mockery::mock(Result::class);
                            $mResult->expects('getWebsite')
                                    ->andReturnUsing(function () {

                                        $mUrl = Mockery::mock(Url::class);
                                        $mUrl->expects('getUrl')
                                             ->andReturn('test.com');
                                        return $mUrl;
                                    });
                            return $mResult;
                        });
            return $mReportData;
        });

        $result = $subscriber->onWebsiteLoadedSlower($mEvent);

        $this->assertNull($result);
    }

    public function testOnWebsiteLoadedSlowerTwice(): void
    {
        $mailService = new EmailService(new SwiftMailer());
        $smsService = new SmsService(new ClickatellGateway());

        $subscriber = new WebsiteLoadedSlowerEventSubscriber(
            $mailService,
            $smsService
        );

        $mEvent = Mockery::mock(WebsiteLoadedSlowerTwiceEvent::class);
        $mEvent->expects('getReportData')->andReturnUsing(function () {

            $mReportData = Mockery::mock(ReportData::class);
            $mReportData->expects('getWebsiteResult')
                        ->andReturnUsing(function () {

                            $mResult = Mockery::mock(Result::class);
                            $mResult->expects('getWebsite')
                                    ->andReturnUsing(function () {

                                        $mUrl = Mockery::mock(Url::class);
                                        $mUrl->expects('getUrl')
                                             ->andReturn('test.com');
                                        return $mUrl;
                                    });
                            return $mResult;
                        });
            return $mReportData;
        });

        $result = $subscriber->onWebsiteLoadedSlowerTwice($mEvent);

        $this->assertNull($result);
    }
}
