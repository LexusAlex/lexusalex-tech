<?php

declare(strict_types=1);

namespace App\Configurations\Error;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Throwable;

final class ErrorMessage
{
    public static function createErrorLogMessage(
        LoggerInterface $logger,
        Throwable $exception,
        ServerRequestInterface $request
    ): void {
        $logger->error($exception->getMessage(), [
            'exception' => $exception,
            'url' => $request->getUri()->getPath(),
            'ip' => (isset($request->getServerParams()['REMOTE_ADDR'])) ? $request->getServerParams()['REMOTE_ADDR'] : null,
        ]);
    }
}
