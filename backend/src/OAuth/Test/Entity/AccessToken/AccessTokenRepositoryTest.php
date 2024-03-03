<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\AccessToken;

use App\OAuth\Entity\AccessToken\AccessToken;
use App\OAuth\Entity\AccessToken\AccessTokenRepository;
use App\OAuth\Entity\Client\Client;
use App\OAuth\Entity\Scope\Scope;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class AccessTokenRepositoryTest extends TestCase
{
    public function testCreate(): void
    {
        $repository = new AccessTokenRepository();
        $client = new Client(Uuid::uuid7()->toString(), 'Client', 'http://localhost/auth');
        $scope = new Scope('common');
        $accessToken = $repository->getNewToken($client, [$scope], '123');

        self::assertFalse($repository->isAccessTokenRevoked('132'));
        self::assertEquals('123', $accessToken->getUserIdentifier());
        self::assertInstanceOf(AccessToken::class, $accessToken);
    }
}
