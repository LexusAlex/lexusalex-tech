<?php

declare(strict_types=1);

namespace App\Http\Action;

use App\Authentication\Query\FindIdByCredentials\Fetcher;
use App\Authentication\Query\FindIdByCredentials\Query;
use App\Configurations\Serializer\Denormalizer;
use App\Http\Response\HtmlResponse;
use App\OAuth\Entity\User\User;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Twig\Environment;

final class AuthorizeAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly AuthorizationServer $server,
        private readonly LoggerInterface $logger,
        private readonly Fetcher $users,
        private readonly Environment $template,
        private readonly ResponseFactoryInterface $response,
        private readonly Denormalizer $denormalizer,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $authRequest = $this->server->validateAuthorizationRequest($request);

            if ($request->getMethod() === 'POST') {

                $queryRequest = $this->denormalizer->denormalize($request->getParsedBody(), Query::class);
                $user = $this->users->fetch($queryRequest);

                if ($user === null) {
                    $error = 'Incorrect email or password.';
                    return new HtmlResponse(
                        $this->template->render('oauth/authorize.html.twig', compact('error')),
                        400
                    );
                }

                /*
                if (!$user->isActive) {
                    $error = 'User is not confirmed.';
                    return new HtmlResponse(
                        $this->template->render('oauth/authorize.html.twig', compact('error')),
                        409
                    );
                }
                */

                $authRequest->setUser(new User($user->id));
                $authRequest->setAuthorizationApproved(true);

                return $this->server->completeAuthorizationRequest($authRequest, $this->response->createResponse());
            }

            return new HtmlResponse(
                $this->template->render('oauth/authorize.html.twig')
            );
        } catch (OAuthServerException $exception) {
            $this->logger->warning($exception->getMessage(), [
                'exception' => $exception,
                'url' => $request->getUri()->getPath(),
                'ip' => (isset($request->getServerParams()['REMOTE_ADDR'])) ? $request->getServerParams()['REMOTE_ADDR'] : null,
            ]);
            return $exception->generateHttpResponse($this->response->createResponse());
        }
    }
}
