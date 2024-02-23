<?php

declare(strict_types=1);

namespace App\Authentication\Fixture;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;

final class UserFixture
{
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
            ->setParameter('id', '00000000-0000-0000-0000-000000000001')
            ->setParameter('email', 'user@lexusalex.tech')
            ->setParameter('password_hash', self::PASSWORD_HASH)
            ->executeQuery();
    }
}
