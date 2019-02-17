<?php
declare(strict_types=1);

namespace App\Application\Command\Report;

use App\Application\Command\CommandHandlerInterface;
use App\Application\Service\Report\LogReportServiceInterface;
use App\Domain\Report\Command\GenerateReportCommand;
use App\Domain\Report\Event\ReportGeneratedEvent;
use App\Domain\Report\Factory\ReportAdapterStaticFactory;
use App\Domain\Report\GenerateReportServiceInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class GenerateReportCommandHandler implements CommandHandlerInterface
{
    private $eventDispatcher;
    private $generateReportService;
    private $logReportService;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        GenerateReportServiceInterface $generateReportService,
        LogReportServiceInterface $logReportService
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->generateReportService = $generateReportService;
        $this->logReportService = $logReportService;
    }

    public function handle(GenerateReportCommand $command): void
    {
        $report = $command->getReportData();
        $reportType = $command->getReportType();

        // dependency to ReportAdapterStaticFactory - should be abstraction instead
        $adapter = ReportAdapterStaticFactory::create($reportType);

        $this->generateReportService->generate($adapter, $report);

        $this->logReportService->dump($report);

        $this->eventDispatcher->dispatch(
            ReportGeneratedEvent::NAME,
            new ReportGeneratedEvent($report)
        );
    }
}
