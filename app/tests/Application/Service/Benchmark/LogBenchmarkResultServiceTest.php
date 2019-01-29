<?php

namespace Tests\Application\Service\Benchmark;

use App\Application\Service\Benchmark\LogBenchmarkResultService;
use App\Domain\Benchmark\ValueObject\Result;
use App\Domain\Url\ValueObject\Url;
use PHPUnit\Framework\TestCase;

class LogBenchmarkResultServiceTest extends TestCase
{
    public function testDump(): void
    {
        $result = new Result(new Url('test.com', false), 0.128);

        $logService = new LogBenchmarkResultService();
        $logService->dump($result);

        $this->assertFileExists(LogBenchmarkResultService::OUTPUT_FILENAME);
        $this->assertFileIsWritable(LogBenchmarkResultService::OUTPUT_FILENAME);
    }
}
