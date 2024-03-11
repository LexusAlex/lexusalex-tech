<?php

declare(strict_types=1);

namespace App\Http\Test\Middleware\Authenticate;

use App\Http\Middleware\Authenticate\Authenticate;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;
use LogicException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;

final class AuthenticateTest extends TestCase
{
    public function testNormal(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects(self::never())->method('warning');

        $server = $this->createMock(ResourceServer::class);
        $responce = $this->createMock(ResponseFactoryInterface::class);

        $middleware = new Authenticate($server, $responce, $logger);

        $handler = $this->createStub(RequestHandlerInterface::class);
        $handler->method('handle')->willReturn($source = (new ResponseFactory())->createResponse());

        $request = (new ServerRequestFactory())->createServerRequest('POST', 'http://test');
        $response = $middleware->process($request, $handler);

        self::assertEquals($source, $response);
    }

    public function testSuccess(): void
    {
        $header = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJmcm9udGVuZCIsImp0aSI6ImQzMDA1Y2ZhOGE0ODU3YTE1NzViNGU2YzYwM2U0YWIxNzkxMDdjN2FmMGFmMDVjYTg0NDgxY2E4MjZlYzcxNzlmNDYwOTc5NDlkMzBlMTM0IiwiaWF0IjoxNzEwMDYwMzUzLjE5NTk4NiwibmJmIjoxNzEwMDYwMzUzLjE5NTk5MiwiZXhwIjozMzI2Njk2OTE1My4xNzMwNCwic3ViIjoiMDAwMDAwMDAtMDAwMC0wMDAwLTAwMDAtMDAwMDAwMDAwMDAxIiwic2NvcGVzIjpbImNvbW1vbiJdfQ.J3fgYuV3CtudqF8gxMvbbFAeVQNn1Z0HNJPtcXZ01jzvam13RprU2XtrS5ntf0MjB5AJymPIALX5Yjyo_OJ0LaRt82MzSLWtP7BT9Wvfbp_qdOsN7rTNiWZW3pUlkt9sQd5NzFA_ECBwhT-yuFD95rCYJWHHac22YTZb0YOSVHNOrxLaaQtbEPePtRgUKKrdgHWUdY8Ga5ahJ27TvHRdo1iIM1CFidyxSgGGcQDMc-d_SaiJvM02st-X2Zm112doA35NJ2DD8Eep3_efmqCSZjOy-NWl6dU8yJjTVJkZQU9WsdQ0iSle-vBaNMWBi77muyzREIABWJew6DIxII3qdQ';
        $logger = $this->createMock(LoggerInterface::class);

        $dependencies = (require __DIR__ . '/../../../../Configurations/Main/dependencies.php')((__DIR__ . '/../../../../../src'));

        $container = (require __DIR__ . '/../../../../Configurations/Main/container.php')($dependencies);

        $server = $container->get(ResourceServer::class);

        $response = $this->createMock(ResponseFactoryInterface::class);

        $middleware = new Authenticate($server, $response, $logger);

        $handler = $this->createStub(RequestHandlerInterface::class);
        $handler->method('handle')->willReturn((new ResponseFactory())->createResponse());

        $request = (new ServerRequestFactory())
            ->createServerRequest('POST', 'http://test')
            ->withHeader('Authorization', $header);
        $main = $middleware->process($request, $handler);

        self::assertEquals($main->getStatusCode(), 200);
    }

    public function testLogicException(): void
    {
        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', 'http://test')
            ->withAttribute('identity', '12321');

        $this->expectException(LogicException::class);
        Authenticate::identity($request);
    }

    public function testNotValidRequest(): void
    {
        $header = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJmcm9udGVuZCIsImp0aSI6ImQzMDA1Y2ZhOGE0ODU3YTE1NzViNGU2YzYwM2U0YWIxNzkxMDdjN2FmMGFmMDVjYTg0NDgxY2E4MjZlYzcxNzlmNDYwOTc5NDlkMzBlMTM0IiwiaWF0IjoxNzEwMDYwMzUzLjE5NTk4NiwibmJmIjoxNzEwMDYwMzUzLjE5NTk5MiwiZXhwIjozMzI2Njk2OTE1My4xNzMwNCwic3ViIjoiMDAwMDAwMDAtMDAwMC0wMDAwLTAwMDAtMDAwMDAwMDAwMDAxIiwic2NvcGVzIjpbImNvbW1vbiJdfQ.J3fgYuV3CtudqF8gxMvbbFAeVQNn1Z0HNJPtcXZ01jzvam13RprU2XtrS5ntf0MjB5AJymPIALX5Yjyo_OJ0LaRt82MzSLWtP7BT9Wvfbp_qdOsN7rTNiWZW3pUlkt9sQd5NzFA_ECBwhT-yuFD95rCYJWHHac22YTZb0YOSVHNOrxLaaQtbEPePtRgUKKrdgHWUdY8Ga5ahJ27TvHRdo1iIM1CFidyxSgGGcQDMc-d_SaiJvM02st-X2Zm112doA35NJ2DD8Eep3_efmqCSZjOy-NWl6dU8yJjTVJkZQU9WsdQ0iSle-vBaNMWBi77muyzREIABWJew6DIxII3qdQ';
        $logger = $this->createMock(LoggerInterface::class);

        $dependencies = (require __DIR__ . '/../../../../Configurations/Main/dependencies.php')((__DIR__ . '/../../../../../src'));

        $container = (require __DIR__ . '/../../../../Configurations/Main/container.php')($dependencies);

        $server = $container->get(ResourceServer::class);

        $response = $this->createMock(ResponseFactoryInterface::class);

        $middleware = new Authenticate($server, $response, $logger);

        $handler = $this->createStub(RequestHandlerInterface::class);
        $handler->method('handle')->willReturn((new ResponseFactory())->createResponse());

        $request = (new ServerRequestFactory())
            ->createServerRequest('POST', 'http://test')
            ->withHeader('Authorization', $header);

        //$this->expectException(OAuthServerException::class);
        //$middleware->process($request, $handler);
    }
}
