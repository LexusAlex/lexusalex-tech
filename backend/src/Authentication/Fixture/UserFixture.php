<?php

declare(strict_types=1);

namespace App\Authentication\Fixture;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;

final class UserFixture
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
            ->setParameter('id', '018d980e-c8f8-7015-ba0f-a3edff3243df')
            ->setParameter('email', 'user@lexusalex.tech')
            ->executeQuery();
    }
}
