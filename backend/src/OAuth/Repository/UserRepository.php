<?php

declare(strict_types=1);

namespace App\OAuth\Repository;

use App\OAuth\Entity\User;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

final class UserRepository implements UserRepositoryInterface
{
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ): ?User {
        return null;
    }
}
