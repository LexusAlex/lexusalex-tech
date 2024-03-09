<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Configurations\Error\ErrorMessage;
use App\Http\Response\JsonResponse;
use DomainException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

final readonly class DomainExceptionHandler implements MiddlewareInterface
{
    public function __construct(
        private LoggerInterface $logger,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (DomainException $exception) {
            ErrorMessage::createWarningLogMessage($this->logger, $exception, $request);
            return new JsonResponse([
                'message' => $exception->getMessage(),
            ], 409);
        }
    }
}
