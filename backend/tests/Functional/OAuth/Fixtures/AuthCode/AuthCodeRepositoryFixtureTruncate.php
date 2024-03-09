<?php

declare(strict_types=1);

namespace Test\Functional\OAuth\Fixtures\AuthCode;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;

final class AuthCodeRepositoryFixtureTruncate
{
    private Connection $connection;
    public function __construct(ContainerInterface $container)
    {
        $this->connection = $container->get(Connection::class);
    }

    public function load(): void
    {
        $this->connection->executeQuery('TRUNCATE oauth_auth_codes');
    }
}
