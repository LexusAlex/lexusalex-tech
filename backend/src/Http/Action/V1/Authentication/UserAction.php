<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Authentication;

use App\Http\Exception\UnauthorizedHttpException;
use App\Http\Middleware\Authenticate\Authenticate;
use App\Http\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class UserAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $identity = Authenticate::identity($request);

        if ($identity === null) {
            throw new UnauthorizedHttpException($request);
        }

        return new JsonResponse([
            'id' => $identity->id,
        ]);
    }
}
