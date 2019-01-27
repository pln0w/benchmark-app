<?php

namespace App\Domain\Report\Service;

use App\Domain\Report\ReportInterface;
use App\Domain\Report\ValueObject\ReportData;

final class ConsoleReportService implements ReportInterface
{
    public function generate(ReportData $reportData): void
    {
        echo 'Console report';
    }
}
