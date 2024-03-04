<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\User;

use App\OAuth\Entity\User\UserRepository;
use App\OAuth\Test\Entity\Builder\ClientBuilder;
use PHPUnit\Framework\TestCase;

final class UserRepositoryTest extends TestCase
{
    public function testCreate(): void
    {
        $client = (new ClientBuilder())->build();
        $repository = new UserRepository();
        self::assertNull($repository->getUserEntityByUserCredentials('user', 'pass', 'grant', $client));
    }
}
