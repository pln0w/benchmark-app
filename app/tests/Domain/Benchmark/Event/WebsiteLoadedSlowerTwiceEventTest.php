<?php

namespace Tests\Domain\Benchmark\Event;

use App\Domain\Benchmark\Event\WebsiteLoadedSlowerTwiceEvent;
use App\Domain\Report\ValueObject\ReportData;
use PHPUnit\Framework\TestCase;

class WebsiteLoadedSlowerTwiceEventTest extends TestCase
{
    public function testEvent(): void
    {
        $report = new ReportData([]);

        $event = new WebsiteLoadedSlowerTwiceEvent($report);

        $this->assertEquals($report, $event->getReportData());
    }
}
