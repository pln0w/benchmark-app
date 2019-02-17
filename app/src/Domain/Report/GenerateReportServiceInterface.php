<?php
declare(strict_types=1);

namespace App\Domain\Report;

use App\Domain\Report\ValueObject\ReportData;

interface GenerateReportServiceInterface
{
    public function generate(GenerateReportAdapterInterface $adapter, ReportData $report): void;
}
