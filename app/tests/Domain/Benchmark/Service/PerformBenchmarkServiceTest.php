<?php
declare(strict_types=1);

namespace Tests\Domain\Benchmark\Service;

use App\Application\Service\Benchmark\LogResultService;
use App\Application\Service\Benchmark\TimeMeasurementService;
use App\Application\Service\Http\HttpClientService;
use App\Domain\Benchmark\Service\PerformBenchmarkService;
use App\Domain\Benchmark\ValueObject\Result;
use App\Domain\Url\ValueObject\Url;
use Mockery;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class PerformBenchmarkServiceTest extends TestCase
{
    public function testRun(): void
    {
        $url = new Url('test.com', false);

        $executionTime = 0.128;

        $result = new Result($url, $executionTime);

        $mTimeMeasurementService = Mockery::mock(TimeMeasurementService::class);
        $mTimeMeasurementService->expects('start');
        $mTimeMeasurementService->expects('stop');
        $mTimeMeasurementService->expects('getExecutionTime')
                                ->andReturn($executionTime);

        $mHttpClientService = Mockery::mock(HttpClientService::class);
        $mHttpClientService->expects('get')
                           ->with($url->getUrl());

        $mLogBenchmarkResultService = Mockery::mock(LogResultService::class);
        $mLogBenchmarkResultService->expects('dump')
                                   ->withAnyArgs();

        $performBenchmarkService = new PerformBenchmarkService(
            $mTimeMeasurementService,
            $mHttpClientService,
            $mLogBenchmarkResultService
        );

        $serviceResult = $performBenchmarkService->run($url);

        $this->assertEquals($result, $serviceResult);
    }

    public function testException(): void
    {
        $url = new Url('test.com', false);

        $executionTime = null;

        $mTimeMeasurementService = Mockery::mock(TimeMeasurementService::class);
        $mTimeMeasurementService->expects('start');
        $mTimeMeasurementService->expects('stop');
        $mTimeMeasurementService->expects('getExecutionTime')
                                ->andReturn($executionTime);

        $mHttpClientService = Mockery::mock(HttpClientService::class);
        $mHttpClientService->expects('get')
                           ->with($url->getUrl());

        $mLogBenchmarkResultService = Mockery::mock(LogResultService::class);
        $mLogBenchmarkResultService->shouldNotReceive('dump');

        $performBenchmarkService = new PerformBenchmarkService(
            $mTimeMeasurementService,
            $mHttpClientService,
            $mLogBenchmarkResultService
        );

        $this->expectException(RuntimeException::class);
        $performBenchmarkService->run($url);
    }

}
