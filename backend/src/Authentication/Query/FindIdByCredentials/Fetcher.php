<?php

declare(strict_types=1);

namespace App\Authentication\Query\FindIdByCredentials;

use App\Authentication\Service\PasswordHasher;
use Doctrine\DBAL\Connection;

final class Fetcher
{
    private Connection $connection;
    private PasswordHasher $hasher;

    public function __construct(Connection $connection, PasswordHasher $hasher)
    {
        $this->connection = $connection;
        $this->hasher = $hasher;
    }

    public function fetch(Query $query): ?User
    {
        $result = $this->connection->createQueryBuilder()
            ->select('id', 'password_hash')
            ->from('authentication_users')
            ->where('email = :email')
            ->setParameter('email', strtolower($query->email))
            ->executeQuery();

        /**
         * @var array{
         *     id: string,
         *     password_hash: ?string,
         * }|false
         */
        $row = $result->fetchAssociative();

        if ($row === false) {
            return null;
        }

        $hash = $row['password_hash'];

        if ($hash === null) {
            return null;
        }

        if (!$this->hasher->validate($query->password, $hash)) {
            return null;
        }

        return new User(
            id: $row['id']
        );
    }
}
