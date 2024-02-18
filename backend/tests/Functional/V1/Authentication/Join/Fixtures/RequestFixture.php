<?php

declare(strict_types=1);

namespace Test\Functional\V1\Authentication\Join\Fixtures;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;

final class RequestFixture
{
    private Connection $connection;
    public function __construct(ContainerInterface $container)
    {
        $this->connection = $container->get(Connection::class);
    }

    public function load(): void
    {
        $this->connection->executeQuery('TRUNCATE authentication_users');
        $this->connection->createQueryBuilder()
            ->insert('authentication_users')
            ->values(
                [
                    'id' => ':id',
                    'email' => ':email',
                ]
            )
            ->setParameter('id', '018d980e-c8f8-7015-ba0f-a3edff3243d5')
            ->setParameter('email', 'existing@lexusalex.tech')
            ->executeQuery();
    }
}
