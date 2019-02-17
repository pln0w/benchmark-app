<?php
declare(strict_types=1);

namespace App\Application\Service\Report;

use App\Domain\Report\ValueObject\ReportData;

interface LogReportServiceInterface
{
    public function dump(ReportData $reportData): void;
}
