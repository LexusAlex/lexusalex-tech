<?php

declare(strict_types=1);

use App\Configurations\Router\StaticRouteGroup as Group;
use App\Http\Action\AuthorizeAction;
use App\Http\Action\HomeAction;
use App\Http\Action\V1\Authentication\Join\RequestAction;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $application): void {
    $application->get('/', HomeAction::class);
    $application->map(['GET', 'POST'], '/authorize', AuthorizeAction::class);
    $application->group('/v1', new Group(static function (RouteCollectorProxy $group): void {
        $group->group('/authentication', new Group(static function (RouteCollectorProxy $group): void {
            $group->post('/join', RequestAction::class);
        }));
    }));
};
