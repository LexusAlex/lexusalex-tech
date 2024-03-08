<?php

declare(strict_types=1);

use App\Http\Middleware\Authenticate\Authenticate;
use App\Http\Middleware\ClearEmptyInput;
use App\Http\Middleware\DenormalizationExceptionHandler;
use App\Http\Middleware\DomainExceptionHandler;
use App\Http\Middleware\ValidationExceptionHandler;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return static function (App $application): void {
    // Выполнение action
    $application->add(Authenticate::class);
    $application->add(DomainExceptionHandler::class);
    $application->add(DenormalizationExceptionHandler::class);
    $application->add(ValidationExceptionHandler::class);
    $application->add(ClearEmptyInput::class);
    $application->addBodyParsingMiddleware();
    $application->add(ErrorMiddleware::class);
};
