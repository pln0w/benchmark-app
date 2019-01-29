<?php

namespace Tests\Application\Service\Http;

use App\Application\Service\Http\GuzzleHttpClient;
use Mockery;
use PHPUnit\Framework\TestCase;

class GuzzleHttpClientTest extends TestCase
{

    public function testGet(): void
    {
        $httpClient = new GuzzleHttpClient();

        $result = $httpClient->get('test.com');

        $this->assertNull($result);
    }
}
