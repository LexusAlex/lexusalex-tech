<?php

declare(strict_types=1);

use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return static function (App $application): void {
    // Выполнение action
    $application->addBodyParsingMiddleware();
    $application->add(ErrorMiddleware::class);
};
