<?php

declare(strict_types=1);

namespace App\Http\Action;

use Exception;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

final class TokenAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly AuthorizationServer $server,
        private LoggerInterface $logger,
        private ResponseFactoryInterface $response,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->response->createResponse();
        try {
            return $this->server->respondToAccessTokenRequest($request, $response);
        } catch (OAuthServerException $exception) {
            $this->logger->warning($exception->getMessage(), [
                'exception' => $exception,
                'url' => (string) $request->getUri(),
                'ip' => (\array_key_exists('REMOTE_ADDR', $request->getServerParams())) ? (string) $request->getServerParams()['REMOTE_ADDR'] : null,]
            );
            return $exception->generateHttpResponse($response);
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), [
                'exception' => $exception,
                'url' => (string) $request->getUri(),
                'ip' => (\array_key_exists('REMOTE_ADDR', $request->getServerParams())) ? (string) $request->getServerParams()['REMOTE_ADDR'] : null,]
            );
            return (new OAuthServerException($exception->getMessage(), 0, 'unknown_error', 500))
                ->generateHttpResponse($response);
        }
    }
}