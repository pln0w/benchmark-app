<?php
namespace Tests\Domain\Benchmark\ValueObject;

use App\Domain\Benchmark\ValueObject\Result;
use App\Domain\Url\ValueObject\Url;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testResult(): void
    {
        $url = new Url('test.com', false);

        $result = new Result($url, 0.128);

        $this->assertEquals($url, $result->getWebsite());
        $this->assertEquals(true, $result->isTheWebsite());
        $this->assertEquals(false, $result->isCompetitor());
        $this->assertEquals('0.128', $result->getFormattedRequestTime());
        $this->assertEquals(0.128, $result->getRequestTime());
        $this->assertEquals(true, $result->isFasterThan(
            new Result(new Url('other.com', true), 0.22)
        ));

        $this->assertEquals(true, $result->isFasterTwiceThan(
            new Result(new Url('fastest.com', true), 0.521)
        ));
    }
}
