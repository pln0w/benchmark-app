<?php

namespace App\Domain\Report\Command;

use App\Domain\Report\ValueObject\ReportData;

class GenerateReportCommand
{
    private $reportData;
    private $reportType;

    public function __construct(ReportData $reportData, string $reportType)
    {
        $this->reportData = $reportData;
        $this->reportType = $reportType;
    }

    public function getReportData(): ReportData
    {
        return $this->reportData;
    }

    public function getReportType(): string
    {
        return $this->reportType;
    }
}
