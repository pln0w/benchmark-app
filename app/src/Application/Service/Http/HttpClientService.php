<?php
declare(strict_types=1);

namespace App\Application\Service\Http;

class HttpClientService implements HttpClientServiceInterface
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
