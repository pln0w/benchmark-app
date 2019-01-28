<?php

namespace App\Application\Service\Benchmark;

use App\Domain\Benchmark\ValueObject\Result;

class LogBenchmarkResultService
{
    private const FILENAME = 'log.txt';

    public function dump(Result $result): void
    {
        $url = $result->getWebsite()->getUrl();
        $time = $result->getFormattedRequestTime();

        $content = sprintf("%s \t%s\n", 'Request time', 'URL');
        $content .= sprintf("%0.3f s \t\t%s\n\n", $time, $url);

        file_put_contents(self::FILENAME, $content, FILE_APPEND);
    }
}
