<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\RefreshToken;

use App\OAuth\Entity\AccessToken\AccessToken;
use App\OAuth\Entity\RefreshToken\RefreshToken;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class RefreshTokenTest extends TestCase
{
    public function testCreate(): void
    {
        $token = new RefreshToken();

        $token->setIdentifier($identifier = Uuid::uuid7()->toString());
        $token->setExpiryDateTime($expiryDateTime = new DateTimeImmutable());
        $token->setAccessToken($accessToken = $this->createStub(AccessToken::class));

        self::assertSame($accessToken, $token->getAccessToken());
        self::assertSame($identifier, $token->getIdentifier());
        self::assertSame($expiryDateTime, $token->getExpiryDateTime());
    }
}
