<?php

declare(strict_types=1);

namespace Test\Functional\OAuth\Fixtures\AuthorizationCode;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;
use Test\Functional\Service\DataFixtures;

final class AuthorizationCodeFixtureTruncate
{
    private Connection $connection;

    private DataFixtures $dataFixtures;
    public function __construct(ContainerInterface $container)
    {
        $this->connection = $container->get(Connection::class);
        $this->dataFixtures = $container->get(DataFixtures::class);
    }

    public function load(): void
    {
        $this->connection->executeQuery($this->dataFixtures->truncateUser());
        $this->connection->executeQuery($this->dataFixtures->truncateAuthCodes());
    }
}
