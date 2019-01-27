<?php

namespace App\Domain\Benchmark\Service;

use App\Domain\Benchmark\ValueObject\Result;
use App\Domain\Url\ValueObject\Url;

class PerformBenchmarkService
{
    // import HTTP request service

    public function run(Url $url): Result
    {
        // start measuring time

        // $this->httpClient->get($url);

        // end measuring time
        // calculate request time

        $requestTime = 0.17;

        $result = new Result($url, $requestTime);

        return $result;
    }
}
