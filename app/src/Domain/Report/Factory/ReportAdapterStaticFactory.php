<?php

namespace App\Domain\Report\Factory;

use App\Domain\Report\GenerateReportAdapterInterface;
use App\UI\Cli\Service\ConsoleReportOutputAdapterService;
use App\UI\Http\Web\Service\WebReportOutputAdapterService;

class ReportAdapterStaticFactory
{
    private const TYPE_CONSOLE = 1;
    private const TYPE_WEB = 2;

    private static $availableTypes = [
        self::TYPE_CONSOLE => 'Console output',
        self::TYPE_WEB     => 'HTML website dump',
    ];

    public static function getDefaultType(): int
    {
        return self::TYPE_CONSOLE;
    }

    public static function getDefaultTypeString(): string
    {
        return self::$availableTypes[self::getDefaultType()];
    }

    public static function getAvailableTypes(): array
    {
        return self::$availableTypes;
    }

    public static function getType(string $type): int
    {
        $arr = array_flip(self::$availableTypes);

        return (int)$arr[$type];
    }

    public static function create(int $choice): GenerateReportAdapterInterface
    {
        switch ($choice) {
            case self::TYPE_WEB:
                return new WebReportOutputAdapterService();
                break;
            case self::TYPE_CONSOLE:
            default:
                return new ConsoleReportOutputAdapterService();
        }
    }
}
