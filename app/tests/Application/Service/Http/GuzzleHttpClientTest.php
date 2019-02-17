<?php
declare(strict_types=1);

namespace Tests\Application\Service\Http;

use App\Application\Service\Http\GuzzleHttpClient;
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
