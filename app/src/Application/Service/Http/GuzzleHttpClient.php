<?php

namespace App\Application\Service\Http;

use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClientInterface
{
    public function get(string $url): void
    {
        $client = new Client([
            'base_uri'        => $url,
            'timeout'         => 5,
            'allow_redirects' => false,
        ]);

        $client->request('GET', $url);
    }
}
