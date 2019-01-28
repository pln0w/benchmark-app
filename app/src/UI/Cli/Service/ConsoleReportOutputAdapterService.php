<?php

namespace App\UI\Cli\Service;

use App\Domain\Report\GenerateReportAdapterInterface;
use App\Domain\Report\ValueObject\ReportData;

final class ConsoleReportOutputAdapterService implements GenerateReportAdapterInterface
{
    public function generate(ReportData $reportData): void
    {
        $theWebsiteUrl = $reportData->getWebsiteResult()->getWebsite()->getUrl();

        print("\nREPORT\n");
        print("\nThe website URL you compare with others: $theWebsiteUrl\n\n");
        print(sprintf("%s %17s \t%s\n", 'Score', 'Request time', 'URL'));

        foreach ($reportData->getResults() as $position => $result) {
            $url = $result->getWebsite()->getUrl();
            $time = $result->getFormattedRequestTime();

            print(sprintf("%0s %19s s \t%s\n", $position + 1, $time, $url));
        }
    }
}
