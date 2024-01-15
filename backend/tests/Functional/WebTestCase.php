<?php

declare(strict_types=1);

namespace Test\Functional;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Psr7\Factory\ServerRequestFactory;

abstract class WebTestCase extends TestCase
{
    private ?App $application = null;

    protected function tearDown(): void
    {
        $this->application = null;
        parent::tearDown();
    }

    protected static function request(string $method, string $path): ServerRequestInterface
    {
        return (new ServerRequestFactory())->createServerRequest($method, $path);
    }

    private function container(): ContainerInterface
    {
        $dependencies = (require __DIR__ . '/../../src/Configurations/Main/dependencies.php')((__DIR__ . '/../../src'));
        /** @var ContainerInterface */
        return (require __DIR__ . '/../../src/Configurations/Main/container.php')($dependencies);
    }

    protected function application(): App
    {
        if ($this->application === null) {
            $this->application = (require __DIR__ . '/../../src/Configurations/Main/application.php')($this->container());
        }
        return $this->application;
    }

    protected static function json(string $method, string $path, array $body = []): ServerRequestInterface
    {
        $request = self::request($method, $path)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json');
        $request->getBody()->write(json_encode($body, JSON_THROW_ON_ERROR));
        return $request;
    }

    protected static function html(string $method, string $path, array $body = []): ServerRequestInterface
    {
        $request = self::request($method, $path)
            ->withHeader('Accept', 'text/html')
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded');
        $request->getBody()->write(http_build_query($body));
        return $request;
    }
}
