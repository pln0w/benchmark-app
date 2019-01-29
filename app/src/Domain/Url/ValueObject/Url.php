<?php

namespace App\Domain\Url\ValueObject;

use RuntimeException;

class Url
{
    private $url;
    private $isCompetitor;

    public function __construct(string $url, bool $isCompetitor)
    {
        if (!$this->isValid($url)) {
            throw new RuntimeException('URL format is invalid.');
        }

        $this->url = $url;
        $this->isCompetitor = $isCompetitor;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function isCompetitor(): bool
    {
        return $this->isCompetitor;
    }

    private function isValid(string $url): bool
    {
        $_domain_regex = "|^[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,})/?$|";
        if (preg_match($_domain_regex, $url)) {
            return true;
        }

        $_regex = '#^([a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))$#';
        if (preg_match($_regex, $url, $matches)) {

            $_parts = parse_url($url);
            if (!in_array($_parts['scheme'], ['http', 'https'])) {
                return false; // @codeCoverageIgnore
            }

            if (!preg_match($_domain_regex, $_parts['host'])) {
                return false;
            }

            return true;
        }

        return false;
    }

    public function equal(Url $url): bool
    {
        return $url->getUrl() === $this->getUrl();
    }
}
