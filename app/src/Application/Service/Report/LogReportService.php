<?php
declare(strict_types=1);

namespace App\Application\Service\Report;

use App\Domain\Report\ValueObject\ReportData;
use DateTime;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class LogReportService implements LogReportServiceInterface
{
    public const OUTPUT_FILENAME = 'log.txt';

    private $fileSystem;

    public function __construct()
    {
        $this->fileSystem = new Filesystem();
    }

    private function getContent(ReportData $reportData): string
    {
        $theWebsiteUrl = $reportData->getWebsiteResult()->getWebsite()->getUrl();
        $date = (new DateTime('now'))->format('Y-m-d H:i:s');

        $content = "\nBenchmark performed at $date\n";
        $content .= "\nThe website URL you compare with others: $theWebsiteUrl\n\n";
        $content .= sprintf("%s %17s \t%s\n", 'Score', 'Request time', 'URL');

        foreach ($reportData->getResults() as $position => $result) {
            $url = $result->getWebsite()->getUrl();
            $time = $result->getFormattedRequestTime();

            $content .= sprintf("%0s %19s s \t%s\n", $position + 1, $time, $url);
        }

        return $content;
    }

    public function dump(ReportData $reportData): void
    {
        $content = $this->getContent($reportData);

        try {

            if (!$this->fileSystem->exists([self::OUTPUT_FILENAME])) {
                $this->fileSystem->dumpFile(self::OUTPUT_FILENAME, $content);
            }

            $this->fileSystem->appendToFile(self::OUTPUT_FILENAME, $content);

        } catch (IOExceptionInterface $exception) {
            echo 'An error occurred while writing to file '.$exception->getPath();
        }
    }
}
