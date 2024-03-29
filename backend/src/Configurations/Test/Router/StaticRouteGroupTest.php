<?php

declare(strict_types=1);

namespace App\Configurations\Test\Router;

use App\Configurations\Router\StaticRouteGroup;
use PHPUnit\Framework\TestCase;
use Slim\Routing\RouteCollectorProxy;

final class StaticRouteGroupTest extends TestCase
{
    public function testSuccess(): void
    {
        $collector = $this->createStub(RouteCollectorProxy::class);

        $callable = static fn(RouteCollectorProxy $collector): RouteCollectorProxy => $collector;

        $group = new StaticRouteGroup($callable);

        self::assertSame($collector, $group($collector));
    }
}
