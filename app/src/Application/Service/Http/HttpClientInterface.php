<?php
declare(strict_types=1);

namespace App\Application\Service\Http;

interface HttpClientInterface
{
    public function get(string $url): void;
}
