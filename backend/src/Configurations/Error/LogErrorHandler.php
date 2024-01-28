<?php

declare(strict_types=1);

namespace App\Configurations\Error;

use Slim\Handlers\ErrorHandler;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class LogErrorHandler extends ErrorHandler
{
    protected function writeToErrorLog(): void
    {
        $this->logger->error($this->exception->getMessage(), [
            'exception' => $this->exception,
            'url' => (string) $this->request->getUri(),
            'ip' => (\array_key_exists('REMOTE_ADDR', $this->request->getServerParams())) ? (string) $this->request->getServerParams()['REMOTE_ADDR'] : null,
        ]);
    }
}
