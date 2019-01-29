<?php

namespace Tests\Domain\Report\Command;

use App\Domain\Report\Command\GenerateReportCommand;
use App\Domain\Report\Factory\ReportAdapterStaticFactory;
use App\Domain\Report\ValueObject\ReportData;
use PHPUnit\Framework\TestCase;

class GenerateReportCommandTest extends TestCase
{
    public function testCommand(): void
    {
        $reportData = new ReportData([]);

        $command = new GenerateReportCommand($reportData, ReportAdapterStaticFactory::getDefaultType());

        $this->assertEquals($reportData, $command->getReportData());
        $this->assertEquals(ReportAdapterStaticFactory::getDefaultType(), $command->getReportType());
    }
}
