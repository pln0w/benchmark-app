<?php

namespace App\Application\Service\Http;

interface HttpClientInterface
{
    public function get(string $url): void;
}
