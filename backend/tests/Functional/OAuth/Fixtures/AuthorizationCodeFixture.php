<?php

declare(strict_types=1);

namespace Test\Functional\OAuth\Fixtures;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;

final class AuthorizationCodeFixture
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
            ->setParameter('id', '00000000-0000-0000-0000-000000000001')
            ->setParameter('email', 'active@app.test')
            ->setParameter('password_hash', self::PASSWORD_HASH)
            ->executeQuery();

        $this->connection->executeQuery('TRUNCATE oauth_auth_codes');
        $this->connection->createQueryBuilder()
            ->insert('oauth_auth_codes')
            ->values(
                [
                    'identifier' => ':identifier',
                    'expiry_date_time' => ':expiry_date_time',
                    'user_identifier' => ':user_identifier',
                ]
            )
            ->setParameter('identifier', 'def50200f204dedbb244ce4539b9e')
            ->setParameter('expiry_date_time', '2300-12-31 21:00:10')
            ->setParameter('user_identifier', '00000000-0000-0000-0000-000000000001')
            ->executeQuery();
    }
}
