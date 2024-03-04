<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\RefreshToken;

use App\OAuth\Entity\RefreshToken\RefreshToken;
use App\OAuth\Test\Entity\Builder\AccessTokenBuilder;
use App\OAuth\Test\Entity\Builder\ClientBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class RefreshTokenTest extends TestCase
{
    public function testCreate(): void
    {
        $token = new RefreshToken();


        $accessToken = (new AccessTokenBuilder())
            ->withUserIdentifier($userIdentifier = Uuid::uuid7()->toString())
            ->build((new ClientBuilder())->build());

        $token->setIdentifier($identifier = Uuid::uuid7()->toString());
        $token->setExpiryDateTime($expiryDateTime = new DateTimeImmutable());
        $token->setAccessToken($accessToken);

        self::assertSame($accessToken, $token->getAccessToken());
        self::assertSame($identifier, $token->getIdentifier());
        self::assertSame($userIdentifier, $token->getUserIdentifier());
        self::assertSame($expiryDateTime, $token->getExpiryDateTime());
    }
}
