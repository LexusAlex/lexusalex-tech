<?php

declare(strict_types=1);

namespace App\Http\Action;

use App\Configurations\Error\ErrorMessage;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

final readonly class TokenAction implements RequestHandlerInterface
{
    public function __construct(
        private AuthorizationServer      $server,
        private LoggerInterface          $logger,
        private ResponseFactoryInterface $response,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->response->createResponse();
        try {
            return $this->server->respondToAccessTokenRequest($request, $response);
        } catch (OAuthServerException $exception) {
            if (ErrorMessage::createErrorLogMessage($this->logger, $exception, $request)) {
                return $exception->generateHttpResponse($response);
            }
        }
        return $response;
    }
}
