<?php

namespace Tests\Application\Command\Report;

use App\Application\Command\Report\GenerateReportCommandHandler;
use App\Domain\Report\Command\GenerateReportCommand;
use App\Domain\Report\Service\GenerateReportService;
use App\Domain\Report\ValueObject\ReportData;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class GenerateReportCommandHandlerTest extends TestCase
{
    public function testHandle(): void
    {
        $mReportData = Mockery::mock(ReportData::class);
        $mReportData->expects('isWebsiteResultSlower')
                    ->andReturnTrue();

        $mReportData->expects('isWebsiteResultSlowerTwice')
                    ->andReturnTrue();

        $mEventDispatcherInterface = Mockery::mock(EventDispatcherInterface::class);
        $mEventDispatcherInterface->expects('dispatch')
                                  ->withAnyArgs()
                                  ->andReturnNull();

        $mEventDispatcherInterface->expects('dispatch')
                                  ->withAnyArgs()
                                  ->andReturnNull();

        $mGenerateReportService = Mockery::mock(GenerateReportService::class);
        $mGenerateReportService->expects('generate')
                               ->withAnyArgs();

        $mGenerateReportCommand = Mockery::mock(GenerateReportCommand::class);
        $mGenerateReportCommand->expects('getReportData')
                               ->andReturn($mReportData);

        $mGenerateReportCommand->expects('getReportType')
                               ->andReturn(1);

        $handler = new GenerateReportCommandHandler(
            $mEventDispatcherInterface,
            $mGenerateReportService
        );

        $result = $handler->handle($mGenerateReportCommand);

        $this->assertNull($result);
    }
}
