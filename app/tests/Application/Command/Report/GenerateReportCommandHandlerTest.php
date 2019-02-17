<?php
declare(strict_types=1);

namespace Tests\Application\Command\Report;

use App\Application\Command\Report\GenerateReportCommandHandler;
use App\Application\Service\Report\LogReportService;
use App\Domain\Report\Command\GenerateReportCommand;
use App\Domain\Report\GenerateReportServiceInterface;
use App\Domain\Report\ValueObject\ReportData;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class GenerateReportCommandHandlerTest extends TestCase
{
    public function testHandle(): void
    {
        $mReportData = Mockery::mock(ReportData::class);

        $mEventDispatcherInterface = Mockery::mock(EventDispatcherInterface::class);
        $mEventDispatcherInterface->expects('dispatch')
                                  ->withAnyArgs()
                                  ->andReturnNull();

        $mGenerateReportService = Mockery::mock(GenerateReportServiceInterface::class);
        $mGenerateReportService->expects('generate')
                               ->withAnyArgs();


        $mLogReportService = Mockery::mock(LogReportService::class);
        $mLogReportService->expects('dump')
                          ->withAnyArgs()
                          ->andReturnNull();

        $handler = new GenerateReportCommandHandler(
            $mEventDispatcherInterface,
            $mGenerateReportService,
            $mLogReportService
        );

        $result = $handler->handle(new GenerateReportCommand($mReportData, 1));

        $this->assertNull($result);
    }
}
