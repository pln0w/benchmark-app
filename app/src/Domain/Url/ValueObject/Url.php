<?php
declare(strict_types=1);

namespace App\Domain\Url\ValueObject;

use RuntimeException;

class Url
{
    private $url;
    private $isCompetitor;
    private const DOMAIN_REGEXP = '|^[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,})/?$|';
    private const REGEXP = '#^([a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))$#';

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
        if (preg_match(self::DOMAIN_REGEXP, $url)) {
            return true;
        }

        if (preg_match(self::REGEXP, $url, $matches)) {

            $parts = parse_url($url);
            if (!in_array($parts['scheme'], ['http', 'https'])) {
                return false; // @codeCoverageIgnore
            }

            if (!preg_match(self::DOMAIN_REGEXP, $parts['host'] ?? '')) {
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
