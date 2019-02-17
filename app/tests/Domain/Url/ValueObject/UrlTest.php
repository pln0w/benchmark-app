<?php
declare(strict_types=1);

namespace Tests\Domain\Url\ValueObject;

use App\Domain\Url\ValueObject\Url;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class UrlTest extends TestCase
{
    public function testValidUrl(): void
    {
        $url = new Url('test.com', false);

        $this->assertEquals('test.com', $url->getUrl());

        $url = new Url('https://subdomain.domain.com', false);

        $this->assertEquals('https://subdomain.domain.com', $url->getUrl());
    }

    public function testInvalidUrl(): void
    {
        $this->expectException(RuntimeException::class);
        new Url('-test.com', false);

        $this->expectException(RuntimeException::class);
        new Url('https://*test.com/', false);

        $this->expectException(RuntimeException::class);
        new Url('file://*test.com/', false);

        $this->expectException(RuntimeException::class);
        new Url('file://sub.test.com/', false);

        $this->expectException(RuntimeException::class);
        new Url('chrome//sub.test.com/', false);
    }

    public function testOtherInvalidUrlCases(): void
    {
        $cases = [
            'only-text',
            'http//missing.colon.example.com/path/?parameter1=value1&parameter2=value2',
            'missing.protocol.example.com/path/',
            'http://example.com\\bad-separator',
            'http://example.com|bad-separator',
            'hasdttp://!&.com|bad-separator',
            'ht tp://example.com',
            'http://exampl e.com',
            'http://example.com/pa th/',
            '../../../relative/path/needs/protocol/resource.txt',
            'http://example.com/#two-fragments#not-allowed',
            'http://example.edu:portMustBeANumber#one-fragment',
            '-test.com',
            'https://*test.com/',
            'file://*test.com/',
            'file://sub.test.com/',
            'chrome//sub.test.com/',
            'ftp://host.com',
        ];

        foreach ($cases as $case) {
            $this->expectException(RuntimeException::class);
            new Url($case, false);
        }
    }
}
