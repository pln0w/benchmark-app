<?php
namespace Tests\Infrastructure\Notification\Email\Adapter;

use App\Infrastructure\Notification\Email\Adapter\SwiftMailer;
use PHPUnit\Framework\TestCase;

class SwiftMailerTest extends TestCase
{
    public function testSend(): void
    {
        $adapter = new SwiftMailer();
        $adapter->send('from', [], 'subject', 'body');

        $body = "body\nEmail sent via SwiftMailer.\n";

        $this->expectOutputString($body);
    }
}
