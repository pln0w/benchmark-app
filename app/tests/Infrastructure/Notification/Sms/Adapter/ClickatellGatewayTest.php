<?php
namespace Tests\Infrastructure\Notification\Sms\Adapter;

use App\Infrastructure\Notification\Sms\Adapter\ClickatellGateway;
use PHPUnit\Framework\TestCase;

class ClickatellGatewayTest extends TestCase
{
    public function testSend(): void
    {
        $adapter = new ClickatellGateway();
        $adapter->send([], 'body');

        $body = "body\nSMS sent via Clickatell gateway.\n";

        $this->expectOutputString($body);
    }
}
