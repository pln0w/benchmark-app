<?php
namespace Tests\Infrastructure\Notification\Sms\Adapter;

use App\Infrastructure\Notification\Sms\Adapter\NexmoGateway;
use PHPUnit\Framework\TestCase;

class NexmoGatewayTest extends TestCase
{
    public function testSend(): void
    {
        $adapter = new NexmoGateway();
        $adapter->send([], 'body');

        $body = "body\nSMS sent via Nexmo gateway.\n";

        $this->expectOutputString($body);
    }
}
