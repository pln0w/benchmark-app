<?php

namespace Tests\Application\Service\Http;

use App\Application\Service\Http\HttpClientInterface;
use App\Application\Service\Http\HttpClientService;
use Mockery;
use PHPUnit\Framework\TestCase;

class HttpClientServiceTest extends TestCase
{

    public function testGet(): void
    {
        $mHttpClientInterface = Mockery::mock(HttpClientInterface::class);
        $mHttpClientInterface->expects('get')
                             ->withArgs(['test.com']);

        $httpClient = new HttpClientService($mHttpClientInterface);

        $result = $httpClient->get('test.com');

        $this->assertNull($result);
    }
}
