<?php
declare(strict_types=1);

namespace App\Application\Service\Benchmark;

interface TimeMeasurementServiceInterface
{
    public function start(): void;

    public function stop(): void;

    public function getExecutionTime(): ?float;
}
