<?php

declare(strict_types=1);

namespace App\Authentication\Entity\User;

use App\Authentication\Entity\User\Types\Email;
use Doctrine\DBAL\Connection;

final class UserRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    public function hasByEmail(Email $email): bool
    {
        $result = $this->connection->createQueryBuilder()
            ->select('id', 'email')
            ->from('authentication_users')
            ->where('email = :email')
            ->setParameter('email', $email->getValue())
            ->executeQuery()
            ->rowCount();

        return !($result === 0);

    }

    public function add(User $user): void
    {
        $this->connection->createQueryBuilder()
            ->insert('authentication_users')
            ->values(
                [
                    'id' => ':id',
                    'email' => ':email',
                ]
            )
            ->setParameter('id', $user->getId())
            ->setParameter('email', $user->getEmail()->getValue())
            ->executeQuery();
    }

}
