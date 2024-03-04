<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\AccessToken;

use App\OAuth\Entity\AccessToken\AccessTokenRepository;
use App\OAuth\Test\Entity\Builder\ClientBuilder;
use App\OAuth\Test\Entity\Builder\ScopeBuilder;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use PHPUnit\Framework\TestCase;

final class AccessTokenRepositoryTest extends TestCase
{
    public function testCreate(): void
    {
        $repository = new AccessTokenRepository();
        $client = (new ClientBuilder())->build();
        /** @var array<array-key, ScopeEntityInterface> $scope */
        $scope = (new ScopeBuilder())->build();

        $accessToken = $repository->getNewToken($client, $scope, '123');

        self::assertFalse($repository->isAccessTokenRevoked('132'));
        self::assertEquals('123', $accessToken->getUserIdentifier());
    }
}
