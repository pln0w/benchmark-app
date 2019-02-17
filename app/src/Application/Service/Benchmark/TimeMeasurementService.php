<?php
declare(strict_types=1);

namespace App\Application\Service\Benchmark;

class TimeMeasurementService implements TimeMeasurementServiceInterface
{
    private $startTime;
    private $stopTime;

    public function start(): void
    {
        $this->startTime = microtime(true);
    }

    public function stop(): void
    {
        $this->stopTime = microtime(true);
    }

    public function getExecutionTime(): ?float
    {
        if (!$this->stopTime) {
            return null;
        }

        return $this->stopTime - $this->startTime;
    }
}
