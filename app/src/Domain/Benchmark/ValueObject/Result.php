<?php
declare(strict_types=1);

namespace App\Domain\Benchmark\ValueObject;

use App\Domain\Url\ValueObject\Url;

class Result
{
    private $website;
    private $requestTime;

    public function __construct(Url $url, float $requestTime)
    {
        $this->website = $url;
        $this->requestTime = $requestTime;
    }

    public function getWebsite(): Url
    {
        return $this->website;
    }

    public function isTheWebsite(): bool
    {
        return !$this->website->isCompetitor();
    }

    public function isCompetitor(): bool
    {
        return $this->website->isCompetitor();
    }

    public function getFormattedRequestTime(): string
    {
        return number_format($this->getRequestTime(), 3);
    }

    public function getRequestTime(): float
    {
        return $this->requestTime;
    }

    public function isFasterThan(Result $otherResult): bool
    {
        return $this->getRequestTime() < $otherResult->getRequestTime();
    }

    public function isFasterTwiceThan(Result $otherResult): bool
    {
        return ($this->getRequestTime() * 2) < $otherResult->getRequestTime();
    }
}
