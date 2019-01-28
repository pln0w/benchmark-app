<?php

namespace App\UI\Http\Web\Service;

use App\Domain\Report\GenerateReportAdapterInterface;
use App\Domain\Report\ValueObject\ReportData;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

final class WebReportOutputAdapterService implements GenerateReportAdapterInterface
{
    public function generate(ReportData $reportData): void
    {
        $filesystemLoader = new FilesystemLoader(__DIR__.'/../templates/%name%');
        $templating = new PhpEngine(new TemplateNameParser(), $filesystemLoader);
        $content = $templating->render('report.html.php', [
            'theWebsiteUrl' => $reportData->getWebsiteResult()->getWebsite()->getUrl(),
            'results'       => $reportData->getResults(),
        ]);

        file_put_contents('index.html', $content);
    }
}
