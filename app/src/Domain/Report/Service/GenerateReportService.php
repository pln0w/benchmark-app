<?php
declare(strict_types=1);

namespace App\Domain\Report\Service;

use App\Domain\Report\GenerateReportAdapterInterface;
use App\Domain\Report\GenerateReportServiceInterface;
use App\Domain\Report\ValueObject\ReportData;

final class GenerateReportService implements GenerateReportServiceInterface
{
    public function generate(GenerateReportAdapterInterface $adapter, ReportData $report): void
    {
        $adapter->generate($report);
    }
}
