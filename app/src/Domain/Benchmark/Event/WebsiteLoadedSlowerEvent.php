<?php

namespace App\Domain\Benchmark\Event;

use App\Domain\Report\ValueObject\ReportData;
use Symfony\Component\EventDispatcher\Event;

class WebsiteLoadedSlowerEvent extends Event
{
    public const NAME = 'website.loaded.slower';

    protected $report;

    public function __construct(ReportData $report)
    {
        $this->report = $report;
    }

    public function getReportData(): ReportData
    {
        return $this->report;
    }
}
