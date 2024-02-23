<?php

declare(strict_types=1);

use App\Http\Middleware\ClearEmptyInput;
use App\Http\Middleware\DomainExceptionHandler;
use App\Http\Middleware\ValidationExceptionHandler;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return static function (App $application): void {
    // Выполнение action
    $application->add(DomainExceptionHandler::class);
    $application->add(ValidationExceptionHandler::class);
    $application->add(ClearEmptyInput::class);
    $application->addBodyParsingMiddleware();
    $application->add(ErrorMiddleware::class);
};
