<?php

namespace App\Application\Command\Report;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Benchmark\Event\WebsiteLoadedSlowerEvent;
use App\Domain\Benchmark\Event\WebsiteLoadedSlowerTwiceEvent;
use App\Domain\Report\Command\GenerateReportCommand;
use App\Domain\Report\Factory\ReportStaticFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class GenerateReportCommandHandler implements CommandHandlerInterface
{
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(GenerateReportCommand $command): void
    {
        $report = $command->getReportData();

        $reportGenerator = ReportStaticFactory::create($command->getReportType());
        $reportGenerator->generate($report);

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
