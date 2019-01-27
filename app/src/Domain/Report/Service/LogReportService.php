<?php

namespace App\Domain\Report\Service;

use App\Domain\Report\ReportInterface;
use App\Domain\Report\ValueObject\ReportData;

final class LogReportService implements ReportInterface
{
    public function generate(ReportData $reportData): void
    {
        echo 'Log report';

        file_put_contents('log.txt', 'test');
    }
}
