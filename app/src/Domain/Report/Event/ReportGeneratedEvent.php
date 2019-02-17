<?php
declare(strict_types=1);

namespace App\Domain\Report\Event;

use App\Domain\Report\ValueObject\ReportData;
use Symfony\Component\EventDispatcher\Event;

final class ReportGeneratedEvent extends Event
{
    public const NAME = 'report.generated';

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
