<?php
declare(strict_types=1);

namespace Tests\Application\Service\Benchmark;

use App\Application\Service\Benchmark\TimeMeasurementService;
use PHPUnit\Framework\TestCase;

class TimeMeasurementServiceTest extends TestCase
{
    public function testGetExecutionTime(): void
    {
        $timeService = new TimeMeasurementService();

        $timeService->start();
        $timeService->stop();
        $result = $timeService->getExecutionTime();

        $this->assertTrue(0 < $result);
    }

    public function testException(): void
    {
        $timeService = new TimeMeasurementService();

        $timeService->start();

        $result = $timeService->getExecutionTime();

        $this->assertNull($result);
    }
}
