<?php

namespace App\Domain\Report;

use App\Domain\Report\ValueObject\ReportData;

interface ReportInterface
{
    public function generate(ReportData $reportData): void;
}
