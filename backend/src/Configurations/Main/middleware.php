<?php

declare(strict_types=1);

use Slim\App;

return static function (App $application): void {
    // Выполнение action
    $application->addBodyParsingMiddleware();
    $application->addErrorMiddleware(true, true, true);
};
