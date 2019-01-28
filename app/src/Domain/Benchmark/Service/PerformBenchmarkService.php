<?php

namespace App\Domain\Benchmark\Service;

use App\Application\Service\Benchmark\LogBenchmarkResultService;
use App\Application\Service\Benchmark\TimeMeasurementService;
use App\Application\Service\Http\HttpClientService;
use App\Domain\Benchmark\ValueObject\Result;
use App\Domain\Url\ValueObject\Url;
use RuntimeException;

class PerformBenchmarkService
{
    private $timeMeasurement;
    private $httpClient;
    private $logBenchmarkResult;

    public function __construct(
        TimeMeasurementService $timeMeasurement,
        HttpClientService $httpClient,
        LogBenchmarkResultService $logBenchmarkResult
    ) {
        $this->timeMeasurement = $timeMeasurement;
        $this->httpClient = $httpClient;
        $this->logBenchmarkResult = $logBenchmarkResult;
    }

    public function run(Url $url): Result
    {
        $this->timeMeasurement->start();

        $this->httpClient->get($url->getUrl());

        $this->timeMeasurement->stop();

        $executionTime = $this->timeMeasurement->getExecutionTime();
        if (null === $executionTime) {
            throw new RuntimeException('Could not retrieve request execution time.');
        }

        $result = new Result($url, $executionTime);

        $this->logBenchmarkResult->dump($result);

        return $result;
    }
}
