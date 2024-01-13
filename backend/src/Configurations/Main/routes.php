<?php

declare(strict_types=1);

use App\Http\Action\AuthorizeAction;
use App\Http\Action\HomeAction;
use App\Http\Action\TokenAction;
use Slim\App;

return static function (App $application): void {
    $application->get('/', HomeAction::class);
    $application->map(['GET', 'POST'], '/authorize', AuthorizeAction::class);
    $application->post('/token', TokenAction::class);
};
