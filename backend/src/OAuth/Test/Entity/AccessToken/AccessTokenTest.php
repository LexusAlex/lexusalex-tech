<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\AccessToken;

use App\OAuth\Entity\AccessToken\AccessToken;
use App\OAuth\Entity\Scope\Scope;
use App\OAuth\Test\Entity\Builder\ClientBuilder;
use App\OAuth\Test\Entity\Builder\ScopeBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class AccessTokenTest extends TestCase
{
    public function testCreate(): void
    {
        $token = new AccessToken(
            $client = (new ClientBuilder())->build(),
            /** @var array<array-key, Scope> $scopes */
            $scopes = (new ScopeBuilder())->build()
        );

        $token->setIdentifier($identifier = Uuid::uuid7()->toString());
        $token->setUserIdentifier($userIdentifier = Uuid::uuid7()->toString());
        $token->setExpiryDateTime($expiryDateTime = new DateTimeImmutable());

        self::assertSame($client, $token->getClient());
        self::assertSame($scopes, $token->getScopes());
        self::assertSame($identifier, $token->getIdentifier());
        self::assertSame($userIdentifier, $token->getUserIdentifier());
        self::assertSame($expiryDateTime, $token->getExpiryDateTime());
    }
}
