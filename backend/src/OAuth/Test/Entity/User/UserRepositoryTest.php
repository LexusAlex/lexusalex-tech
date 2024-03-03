<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\User;

use App\OAuth\Entity\Client\Client;
use App\OAuth\Entity\User\UserRepository;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class UserRepositoryTest extends TestCase
{
    public function testCreate(): void
    {
        $client = new Client(Uuid::uuid7()->toString(), 'Client', 'http://localhost/auth');
        $repository = new UserRepository();
        self::assertNull($repository->getUserEntityByUserCredentials('user', 'pass', 'grant', $client));
    }
}
