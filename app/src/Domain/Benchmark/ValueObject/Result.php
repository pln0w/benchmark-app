<?php

namespace App\Domain\Benchmark\ValueObject;

use App\Domain\Url\ValueObject\Url;

class Result
{
    private $url;
    private $requestTime;

    public function __construct(Url $url, float $requestTime)
    {
        $this->url = $url;
        $this->requestTime = $requestTime;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function isCompetitor(): bool
    {
        return $this->url->isCompetitor();
    }

    public function getRequestTime(): float
    {
        return $this->requestTime;
    }

    public function isFasterThan(Result $otherResult): bool
    {
        return $this->getRequestTime() < $otherResult->getRequestTime();
    }
}
