<?php
declare(strict_types=1);

namespace Tests\Domain\Report\ValueObject;

use App\Domain\Benchmark\ValueObject\Result;
use App\Domain\Report\ValueObject\ReportData;
use App\Domain\Url\ValueObject\Url;
use PHPUnit\Framework\TestCase;

class ReportDataTest extends TestCase
{
    public function testIsWebsiteResultSlower(): void
    {
        $results = [
            new Result(new Url('test.com', false), 0.522),
            new Result(new Url('other.com', true), 0.187),
        ];

        $reportData = new ReportData($results);

        $this->assertTrue($reportData->isWebsiteResultSlower());
        $this->assertTrue($reportData->isWebsiteResultSlowerTwice());
    }

    public function testIsWebsiteResultFaster(): void
    {
        $results = [
            new Result(new Url('test.com', false), 0.187),
            new Result(new Url('other.com', true), 0.455),
        ];

        $reportData = new ReportData($results);

        $this->assertFalse($reportData->isWebsiteResultSlower());
        $this->assertFalse($reportData->isWebsiteResultSlowerTwice());
    }
}
