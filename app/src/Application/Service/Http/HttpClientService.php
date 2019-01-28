<?php

namespace App\Application\Service\Http;

class HttpClientService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function get(string $url): void
    {
        $this->httpClient->get($url);
    }
}
