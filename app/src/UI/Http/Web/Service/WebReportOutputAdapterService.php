<?php
declare(strict_types=1);

namespace App\UI\Http\Web\Service;

use App\Domain\Report\GenerateReportAdapterInterface;
use App\Domain\Report\ValueObject\ReportData;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

final class WebReportOutputAdapterService implements GenerateReportAdapterInterface
{
    public const OUTPUT_FILENAME = 'index.html';

    private $fileSystem;

    public function __construct()
    {
        $this->fileSystem = new Filesystem();
    }

    public function generate(ReportData $reportData): void
    {
        $filesystemLoader = new FilesystemLoader(__DIR__.'/../templates/%name%');
        $templating = new PhpEngine(new TemplateNameParser(), $filesystemLoader);

        $content = $templating->render('report.html.php', [
            'theWebsiteUrl' => $reportData->getWebsiteResult()->getWebsite()->getUrl(),
            'results'       => $reportData->getResults(),
        ]);

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
