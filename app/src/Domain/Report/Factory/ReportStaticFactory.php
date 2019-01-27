<?php

namespace App\Domain\Report\Factory;

use App\Domain\Report\ReportInterface;
use App\Domain\Report\Service\ConsoleReportService;
use App\Domain\Report\Service\LogReportService;
use App\Domain\Report\Service\WebReportService;

class ReportStaticFactory
{
    private const TYPE_CONSOLE = 1;
    private const TYPE_LOG = 2;
    private const TYPE_WEB = 3;

    private static $availableTypes = [
        self::TYPE_CONSOLE => 'Console output',
        self::TYPE_LOG => 'Log text file',
        self::TYPE_WEB => 'HTML website dump',
    ];

    public static function getDefaultType(): string
    {
        return self::TYPE_CONSOLE;
    }

    public static function getAvailableTypes(): array
    {
        return self::$availableTypes;
    }

    public static function getAvailableTypesFlip(): array
    {
        return array_flip(self::$availableTypes);
    }

    public static function create(int $choice): ReportInterface
    {
        switch ($choice) {
            case self::TYPE_LOG:
                return new LogReportService();
                break;
            case self::TYPE_WEB:
                return new WebReportService();
                break;
            case self::TYPE_CONSOLE:
            default:
                return new ConsoleReportService();
        }
    }
}
