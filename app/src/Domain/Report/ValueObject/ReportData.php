<?php

namespace App\Domain\Report\ValueObject;

use App\Domain\Benchmark\ValueObject\Result;

class ReportData
{
    private $websiteResult;
    private $competitorsWebsitesResults;

    public function __construct(array $results)
    {
        $this->competitorsWebsitesResults = [];

        foreach ($results as $result) {
            if ($result->isCompetitor()) {
                $this->websiteResult = $result;
            } else {
                $this->competitorsWebsitesResults[] = $result;
            }
        }
    }

    public function getWebsiteResult(): Result
    {
        return $this->websiteResult;
    }

    public function getCompetitorsWebsitesResults(): array
    {
        return $this->competitorsWebsitesResults;
    }

    public function isWebsiteResultSlower(): bool
    {
        foreach ($this->getCompetitorsWebsitesResults() as $competitorResult) {
            if ($competitorResult->isFasterThan($this->getWebsiteResult())) {

            }
        }
        return true;
    }

    public function isWebsiteResultSlowerTwice(): bool
    {
        return true;
    }
}
