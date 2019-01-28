<?php

namespace App\Domain\Report;

use App\Domain\Report\ValueObject\ReportData;

interface GenerateReportAdapterInterface
{
    public function generate(ReportData $reportData): void;
}
