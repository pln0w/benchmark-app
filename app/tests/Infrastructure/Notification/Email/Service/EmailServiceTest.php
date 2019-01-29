<?php
namespace Tests\Infrastructure\Notification\Email\Service;

use App\Infrastructure\Notification\Email\MailerInterface;
use App\Infrastructure\Notification\Email\Service\EmailService;
use Mockery;
use PHPUnit\Framework\TestCase;

class EmailServiceTest extends TestCase
{
    public function testSend(): void
    {
        $mMailer = Mockery::mock(MailerInterface::class);
        $mMailer->expects('send')->withAnyArgs();

        $emailService = new EmailService($mMailer);
        $result = $emailService->send('test');

        $this->assertNull($result);
    }
}
