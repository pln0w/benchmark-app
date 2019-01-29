<?php

namespace Tests\Domain\Report\Factory;

use App\Domain\Report\Factory\ReportAdapterStaticFactory;
use App\UI\Cli\Service\ConsoleReportOutputAdapterService;
use App\UI\Http\Web\Service\WebReportOutputAdapterService;
use PHPUnit\Framework\TestCase;

class ReportAdapterStaticFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $factory = new ReportAdapterStaticFactory();

        $result = $factory::create(ReportAdapterStaticFactory::getDefaultType());
        $this->assertInstanceOf(ConsoleReportOutputAdapterService::class, $result);

        $result2 = $factory::create(2);
        $this->assertInstanceOf(WebReportOutputAdapterService::class, $result2);
    }
}
