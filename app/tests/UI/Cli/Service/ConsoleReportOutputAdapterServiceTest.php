<?php

namespace Tests\UI\Cli\Service;

use App\Domain\Benchmark\ValueObject\Result;
use App\Domain\Report\ValueObject\ReportData;
use App\Domain\Url\ValueObject\Url;
use App\UI\Cli\Service\ConsoleReportOutputAdapterService;
use PHPUnit\Framework\TestCase;

class ConsoleReportOutputAdapterServiceTest extends TestCase
{
    public function testGenerate(): void
    {
        $reportData = new ReportData([
            new Result(new Url('test.com', false), 0.128)
        ]);

        $consoleReportAdapter = new ConsoleReportOutputAdapterService();

        $expectedContent = "\nREPORT\n";
        $expectedContent .= "\nThe website URL you compare with others: test.com\n\n";
        $expectedContent .= sprintf("%s %17s \t%s\n", 'Score', 'Request time', 'URL');
        $expectedContent .= sprintf("%0s %19s s \t%s\n", 1, 0.128, 'test.com');

        $this->expectOutputString($expectedContent);
        $consoleReportAdapter->generate($reportData);
    }
}
