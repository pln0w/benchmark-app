<?php
namespace Tests\Infrastructure\Notification\Email\Adapter;

use App\Infrastructure\Notification\Email\Adapter\PhpMailer;
use PHPUnit\Framework\TestCase;

class PhpMailerTest extends TestCase
{
    public function testSend(): void
    {
        $adapter = new PhpMailer();
        $adapter->send('from', [], 'subject', 'body');

        $body = "body\nEmail sent via PhpMailer.\n";

        $this->expectOutputString($body);
    }
}
