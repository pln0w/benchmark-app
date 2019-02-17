<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Notification\Sms\Service;

use App\Infrastructure\Notification\Sms\Service\SmsService;
use App\Infrastructure\Notification\Sms\SmsGatewayInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class SmsServiceTest extends TestCase
{
    public function testSend(): void
    {
        $mGateway = Mockery::mock(SmsGatewayInterface::class);
        $mGateway->expects('send')->withAnyArgs();

        $emailService = new SmsService($mGateway);
        $result = $emailService->send('test');

        $this->assertNull($result);
    }
}
