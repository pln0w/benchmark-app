<?php

namespace Tests\Domain\Benchmark\Event;

use App\Domain\Benchmark\Event\WebsiteLoadedSlowerEvent;
use App\Domain\Report\ValueObject\ReportData;
use PHPUnit\Framework\TestCase;

class WebsiteLoadedSlowerEventTest extends TestCase
{
    public function testEvent(): void
    {
        $report = new ReportData([]);

        $event = new WebsiteLoadedSlowerEvent($report);

        $this->assertEquals($report, $event->getReportData());
    }
}
