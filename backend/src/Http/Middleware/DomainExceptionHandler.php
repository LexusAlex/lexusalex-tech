<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Response\JsonResponse;
use DomainException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

final class DomainExceptionHandler implements MiddlewareInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (DomainException $exception) {
            $this->logger->warning($exception->getMessage(), [
                'exception' => $exception,
                'url' => $request->getUri()->getPath(),
                'ip' => (isset($request->getServerParams()['REMOTE_ADDR'])) ? $request->getServerParams()['REMOTE_ADDR'] : null,
            ]);
            return new JsonResponse([
                'message' => $exception->getMessage(),
            ], 409);
        }
    }
}