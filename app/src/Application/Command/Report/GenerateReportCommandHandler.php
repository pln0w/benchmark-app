<?php

namespace App\Application\Command\Report;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Benchmark\Event\WebsiteLoadedSlowerEvent;
use App\Domain\Benchmark\Event\WebsiteLoadedSlowerTwiceEvent;
use App\Domain\Report\Command\GenerateReportCommand;
use App\Domain\Report\Factory\GenerateReportAdapterStaticFactory;
use App\Domain\Report\Service\GenerateReportService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class GenerateReportCommandHandler implements CommandHandlerInterface
{
    private $eventDispatcher;
    private $generateReportService;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        GenerateReportService $generateReportService
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->generateReportService = $generateReportService;
    }

    public function handle(GenerateReportCommand $command): void
    {
        $report = $command->getReportData();
        $reportType = $command->getReportType();

        $adapter = GenerateReportAdapterStaticFactory::create($reportType);

        $this->generateReportService->generate($adapter, $report);

        if ($report->isWebsiteResultSlower()) {
            $this->eventDispatcher->dispatch(
                WebsiteLoadedSlowerEvent::NAME,
                new WebsiteLoadedSlowerEvent($report)
            );
        }

        if ($report->isWebsiteResultSlowerTwice()) {
            $this->eventDispatcher->dispatch(
                WebsiteLoadedSlowerTwiceEvent::NAME,
                new WebsiteLoadedSlowerTwiceEvent($report)
            );
        }
    }
}
