<?php

declare(strict_types=1);

namespace App\Http\Middleware\Authenticate;

use App\Configurations\Error\ErrorMessage;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;
use LogicException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

final class Authenticate implements MiddlewareInterface
{
    private const string ATTRIBUTE = 'identity';

    public function __construct(
        private readonly ResourceServer $server,
        private readonly ResponseFactoryInterface $response,
        private readonly LoggerInterface $logger
    ) {}

    public static function identity(ServerRequestInterface $request): ?Identity
    {
        $identity = $request->getAttribute(self::ATTRIBUTE);

        if ($identity !== null && !$identity instanceof Identity) {
            throw new LogicException('Invalid identity.');
        }

        return $identity;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$request->hasHeader('authorization')) {
            return $handler->handle($request);
        }

        try {
            $request = $this->server->validateAuthenticatedRequest($request);
        } catch (OAuthServerException $exception) {
            ErrorMessage::createErrorLogMessage($this->logger, $exception, $request);
            return $exception->generateHttpResponse($this->response->createResponse());
        }

        $identity = new Identity(
            id: $request->getAttribute('oauth_user_id'),
        );

        return $handler->handle($request->withAttribute(self::ATTRIBUTE, $identity));
    }
}
