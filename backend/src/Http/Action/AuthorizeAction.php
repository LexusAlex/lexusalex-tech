<?php

declare(strict_types=1);

namespace App\Http\Action;

use App\Authentication\Query\FindIdByCredentials\Fetcher;
use App\Authentication\Query\FindIdByCredentials\Query;
use App\Configurations\Error\ErrorMessage;
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

final readonly class AuthorizeAction implements RequestHandlerInterface
{
    public function __construct(
        private AuthorizationServer      $server,
        private LoggerInterface          $logger,
        private Fetcher                  $users,
        private Environment              $template,
        private ResponseFactoryInterface $response,
        private Denormalizer             $denormalizer,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->response->createResponse();

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

            if (ErrorMessage::createErrorLogMessage($this->logger, $exception, $request)) {
                return $exception->generateHttpResponse($this->response->createResponse());
            }

        }
        return $response;
    }
}
