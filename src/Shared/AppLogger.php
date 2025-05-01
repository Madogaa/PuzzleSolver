<?php

namespace App\Shared;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AppLogger
{
    private static ?Logger $logger = null;

    public static function getLogger(): Logger
    {
        if (self::$logger === null) {
            self::initLogger();
        }

        return self::$logger;
    }

    private static function initLogger(): void
    {
        self::$logger = new Logger('app');
        self::$logger->pushHandler(
            new StreamHandler(
                stream: __DIR__ . '/../../logs/app.log',
                level: Level::Debug
            )
        );
    }
}
