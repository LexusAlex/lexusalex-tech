<?php

declare(strict_types=1);

namespace App\Configurations\Test\Main;

use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

final class ApplicationTest extends TestCase
{
    public function testCreateApplication(): void
    {
        $dependencies = (require __DIR__ . '/../../Main/dependencies.php')((__DIR__. '/src'));

        $container = (require __DIR__ . '/../../Main/container.php')($dependencies);

        $application = (require __DIR__ . '/../../Main/application.php')($container);

        $request = (new ServerRequestFactory())->createServerRequest('GET', '/');

        $response = $application->handle($request);

        self::assertEquals(200, $response->getStatusCode());

    }
}
