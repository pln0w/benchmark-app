<?php

namespace App\Application\Service\Benchmark;

class TimeMeasurementService
{
    private $startTime;
    private $stopTime;

    public function __construct()
    {
        date_default_timezone_set('UTC');
    }

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
            return null ;
        }

        return $this->stopTime - $this->startTime;
    }
}
