<?php

declare(strict_types=1);

use App\Http\Middleware\ClearEmptyInput;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return static function (App $application): void {
    // Выполнение action
    $application->add(ClearEmptyInput::class);
    $application->addBodyParsingMiddleware();
    $application->add(ErrorMiddleware::class);
};
