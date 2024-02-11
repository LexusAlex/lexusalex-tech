<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Authentication\Join;

use App\Authentication\Command\JoinByEmail\Request\Command;
use App\Authentication\Command\JoinByEmail\Request\Handler;
use App\Http\Response\EmptyResponse;
use App\Http\Response\JsonResponse;
use DomainException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RequestAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly Handler $handler
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /**
         * @psalm-var array{email :?string, password:?string} $data
         */
        $data = $request->getParsedBody();

        $command = new Command();
        $command->email = $data['email'] ?? '';
        $command->password = $data['password'] ?? '';

        try {
            $this->handler->handle($command);
            return new EmptyResponse(201);
        } catch (DomainException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], 409);
        }



    }
}
