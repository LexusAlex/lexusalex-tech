<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Authentication\Join;

use App\Authentication\Command\JoinByEmail\Request\Command;
use App\Authentication\Command\JoinByEmail\Request\Handler;
use App\Configurations\Serializer\Denormalizer;
use App\Configurations\Validator\Validator;
use App\Http\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RequestAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly Handler $handler,
        private readonly Validator $validator,
        private readonly Denormalizer $denormalizer,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $command = $this->denormalizer->denormalize($request->getParsedBody(), Command::class);

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new EmptyResponse(201);
    }
}
