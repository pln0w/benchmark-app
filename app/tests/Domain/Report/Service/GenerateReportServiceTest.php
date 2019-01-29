<?php

namespace Tests\Domain\Report\Service;

use App\Domain\Report\GenerateReportAdapterInterface;
use App\Domain\Report\Service\GenerateReportService;
use App\Domain\Report\ValueObject\ReportData;
use Mockery;
use PHPUnit\Framework\TestCase;

class GenerateReportServiceTest extends TestCase
{
    public function testGenerate(): void
    {
        $report = new ReportData([]);

        $mGenerateReportAdapterInterface = Mockery::mock(GenerateReportAdapterInterface::class);
        $mGenerateReportAdapterInterface->expects('generate')
                                        ->withArgs([$report]);

        $reportService = new GenerateReportService();
        $result = $reportService->generate($mGenerateReportAdapterInterface, $report);

        $this->assertNull($result);
    }
}
