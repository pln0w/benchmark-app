<?php
declare(strict_types=1);

namespace App\Domain\Benchmark\Service;

use App\Application\Service\Benchmark\TimeMeasurementServiceInterface;
use App\Application\Service\Http\HttpClientServiceInterface;
use App\Domain\Benchmark\ValueObject\Result;
use App\Domain\Url\ValueObject\Url;
use Exception;
use RuntimeException;

class PerformBenchmarkService
{
    private $timeMeasurement;
    private $httpClient;

    public function __construct(
        TimeMeasurementServiceInterface $timeMeasurement,
        HttpClientServiceInterface $httpClient
    ) {
        $this->timeMeasurement = $timeMeasurement;
        $this->httpClient = $httpClient;
    }

    public function run(Url $url): Result
    {
        $this->timeMeasurement->start();

        try {

            $this->httpClient->get($url->getUrl());

        } catch (Exception $e) {
            $notRespondingUrl = $url->getUrl();
            throw new RuntimeException("Could not connect with $notRespondingUrl");
        }

        $this->timeMeasurement->stop();

        $executionTime = $this->timeMeasurement->getExecutionTime();
        if (null === $executionTime) {
            throw new RuntimeException('Could not retrieve request execution time.');
        }

        $result = new Result($url, $executionTime);

        return $result;
    }
}
