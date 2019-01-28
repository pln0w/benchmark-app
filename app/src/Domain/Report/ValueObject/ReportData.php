<?php

namespace App\Domain\Report\ValueObject;

use App\Domain\Benchmark\ValueObject\Result;

class ReportData
{
    private $websiteResult;
    private $results;

    public function __construct(array $results)
    {
        $this->results = [];

        foreach ($results as $result) {
            if (!$result->isCompetitor()) {
                $this->websiteResult = $result;
            }

            $this->results[] = $result;
        }

        usort($this->results, function ($a, $b) {
            return $a->getRequestTime() > $b->getRequestTime();
        });
    }

    public function getWebsiteResult(): Result
    {
        return $this->websiteResult;
    }

    public function getResults(): array
    {
        return $this->results;
    }

    public function isWebsiteResultSlower(): bool
    {
        foreach ($this->getResults() as $result) {
            if (!$result->getWebsite()->equal($this->getWebsiteResult()->getWebsite())
                && $result->isFasterThan($this->getWebsiteResult())) {
                return true;
            }
        }

        return false;
    }

    public function isWebsiteResultSlowerTwice(): bool
    {
        foreach ($this->getResults() as $result) {
            if (!$result->getWebsite()->equal($this->getWebsiteResult()->getWebsite())
                && $result->isFasterTwiceThan($this->getWebsiteResult())) {
                return true;
            }
        }

        return false;
    }
}
