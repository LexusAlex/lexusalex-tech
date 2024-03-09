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
        ErrorMessage::createErrorLogMessage($this->logger, $this->exception, $this->request);
    }
}
