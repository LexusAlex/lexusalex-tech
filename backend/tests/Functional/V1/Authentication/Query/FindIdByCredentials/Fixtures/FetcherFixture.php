<?php

declare(strict_types=1);

namespace Test\Functional\V1\Authentication\Query\FindIdByCredentials\Fixtures;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;

final class FetcherFixture
{
    // pass
    private const PASSWORD_HASH = '$argon2i$v=19$m=16,t=4,p=1$TEEvQkF6dGRWZmRGbmFHNA$4ga3MX6bI5AnDNwfTUw3lTVmJlBggT9/fvjF4tOuxrM';
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
                    'password_hash' => ':password_hash',
                ]
            )
            ->setParameter('id', '018d980e-c8f8-7015-ba0f-a3edff3243d5')
            ->setParameter('email', 'tech@lexusalex.tech')
            ->setParameter('password_hash', self::PASSWORD_HASH)
            ->executeQuery();
    }
}
