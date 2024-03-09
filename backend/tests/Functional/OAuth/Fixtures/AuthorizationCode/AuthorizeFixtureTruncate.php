<?php

declare(strict_types=1);

namespace Test\Functional\OAuth\Fixtures\AuthorizationCode;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;

final class AuthorizeFixtureTruncate
{
    private Connection $connection;
    public function __construct(ContainerInterface $container)
    {
        $this->connection = $container->get(Connection::class);
    }

    public function load(): void
    {
        $this->connection->executeQuery('TRUNCATE authentication_users');
    }
}
