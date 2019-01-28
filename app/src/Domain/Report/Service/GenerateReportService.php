<?php

namespace App\Domain\Report\Service;

use App\Domain\Report\GenerateReportAdapterInterface;
use App\Domain\Report\ValueObject\ReportData;

class GenerateReportService
{
    public function generate(GenerateReportAdapterInterface $adapter, ReportData $report): void
    {
        $adapter->generate($report);
    }
}
