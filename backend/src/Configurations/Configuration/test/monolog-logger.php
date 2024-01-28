<?php

declare(strict_types=1);

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

return [
    LoggerInterface::class => static function () {
        $file = __DIR__ . '/../../../../var/log/' . PHP_SAPI . '/test-application.log';
        $logger = new Logger('tech');

        $logger->pushHandler(new RotatingFileHandler($file));

        return $logger;
    },
];
