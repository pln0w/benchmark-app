<?php
declare(strict_types=1);

namespace App\Application\Service\Http;

use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClientInterface
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout'         => 5,
            'allow_redirects' => false,
        ]);
    }

    public function get(string $url): void
    {
        $this->client->request('GET', $url);
    }
}
