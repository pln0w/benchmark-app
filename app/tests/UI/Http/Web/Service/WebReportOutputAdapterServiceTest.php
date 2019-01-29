<?php

namespace Tests\UI\Http\Web\Service;

use App\Domain\Benchmark\ValueObject\Result;
use App\Domain\Report\ValueObject\ReportData;
use App\Domain\Url\ValueObject\Url;
use App\UI\Http\Web\Service\WebReportOutputAdapterService;
use PHPUnit\Framework\TestCase;

class WebReportOutputAdapterServiceTest extends TestCase
{
    public function testGenerate(): void
    {
        $reportData = new ReportData([
            new Result(new Url('test.com', false), 0.128),
        ]);

        $webReportAdapter = new WebReportOutputAdapterService();

        $webReportAdapter->generate($reportData);
        $this->assertFileExists(WebReportOutputAdapterService::OUTPUT_FILENAME);
    }
}
