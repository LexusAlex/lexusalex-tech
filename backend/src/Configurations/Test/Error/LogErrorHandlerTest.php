<?php

declare(strict_types=1);

namespace App\Configurations\Test\Error;

use App\Configurations\Error\LogErrorHandler;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Psr7\Factory\ServerRequestFactory;

final class LogErrorHandlerTest extends TestCase
{
    private function getMockLogger(): LoggerInterface
    {
        return $this->createMock(LoggerInterface::class);
    }

    public function testCreateApplication(): void
    {
        $dependencies = (require __DIR__ . '/../../Main/dependencies.php')((__DIR__ . '/../../../../src'));

        $container = (require __DIR__ . '/../../Main/container.php')($dependencies);

        $callableResolver = $container->get(CallableResolverInterface::class);
        $responseFactory = $container->get(ResponseFactoryInterface::class);
        $logger = $this->getMockLogger();

        $handler = new LogErrorHandler($callableResolver, $responseFactory, $logger);

        $request = (new ServerRequestFactory())->createServerRequest('GET', '/');

        $logger->expects(self::once())
            ->method('error')
            ->willReturnCallback(static function (string $error): void {
                self::assertStringNotContainsString(
                    'set "displayErrorDetails" to true in the ErrorHandler constructor',
                    $error
                );
            });

        $exception = new HttpNotFoundException($request);
        $handler->__invoke($request, $exception, true, true, true);
    }
}
