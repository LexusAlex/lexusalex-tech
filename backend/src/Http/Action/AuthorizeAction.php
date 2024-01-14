<?php

declare(strict_types=1);

namespace App\Http\Action;

use App\Http\Response\HtmlResponse;
use App\OAuth\Entity\User;
use Exception;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

final class AuthorizeAction implements RequestHandlerInterface
{
    private AuthorizationServer $server;
    private LoggerInterface $logger;
    private ResponseFactoryInterface $response;

    public function __construct(
        AuthorizationServer $server,
        LoggerInterface $logger,
        ResponseFactoryInterface $response
    ) {
        $this->server = $server;
        $this->logger = $logger;
        $this->response = $response;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        try {
            $authRequest = $this->server->validateAuthorizationRequest($request);
            
            if ($request->getMethod() === 'POST') {

                
                $authRequest->setUser(new User('00000000-0000-0000-0000-000000000001'));
                $authRequest->setAuthorizationApproved(true);

                return $this->server->completeAuthorizationRequest($authRequest, $this->response->createResponse());
            }

            return new HtmlResponse(
                'authorize'
            );
        } catch (OAuthServerException $exception) {
            $this->logger->warning($exception->getMessage(), [
                    'exception' => $exception,
                    'url' => (string) $request->getUri(),
                    'ip' => (\array_key_exists('REMOTE_ADDR', $request->getServerParams())) ? (string) $request->getServerParams()['REMOTE_ADDR'] : null,]
            );
            return $exception->generateHttpResponse($this->response->createResponse());
        }
    }
}
