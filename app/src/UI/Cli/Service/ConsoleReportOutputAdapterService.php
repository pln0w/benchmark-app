<?php
declare(strict_types=1);

namespace App\UI\Cli\Service;

use App\Domain\Report\GenerateReportAdapterInterface;
use App\Domain\Report\ValueObject\ReportData;
use Symfony\Component\Console\Output\OutputInterface;

final class ConsoleReportOutputAdapterService implements GenerateReportAdapterInterface
{
    private $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function generate(ReportData $reportData): void
    {
        $theWebsiteUrl = $reportData->getWebsiteResult()->getWebsite()->getUrl();

        $this->output->write("\nREPORT\n");
        $this->output->write("\nThe website URL you compare with others: $theWebsiteUrl\n\n");
        $this->output->write(sprintf("%s %17s \t%s\n", 'Score', 'Request time', 'URL'));

        foreach ($reportData->getResults() as $position => $result) {
            $url = $result->getWebsite()->getUrl();
            $time = $result->getFormattedRequestTime();

            $this->output->write(sprintf("%0s %19s s \t%s\n", $position + 1, $time, $url));
        }
    }
}
