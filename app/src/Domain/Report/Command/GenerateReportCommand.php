<?php

namespace App\Domain\Report\Command;

use App\Domain\Report\ValueObject\ReportData;

class GenerateReportCommand
{
    private $reportData;
    private $reportType;

    public function __construct(ReportData $reportData, int $reportType)
    {
        $this->reportData = $reportData;
        $this->reportType = $reportType;
    }

    public function getReportData(): ReportData
    {
        return $this->reportData;
    }

    public function getReportType(): int
    {
        return $this->reportType;
    }
}
