<?php
declare(strict_types=1);

namespace Tests\Domain\Report\Event;

use App\Domain\Benchmark\Event\WebsiteLoadedSlowerEvent;
use App\Domain\Report\Event\ReportGeneratedEvent;
use App\Domain\Report\ValueObject\ReportData;
use PHPUnit\Framework\TestCase;

class ReportGeneratedEventTest extends TestCase
{
    public function testEvent(): void
    {
        $report = new ReportData([]);

        $event = new ReportGeneratedEvent($report);

        $this->assertEquals($report, $event->getReportData());
    }
}
