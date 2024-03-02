<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\AuthCode;

use App\OAuth\Entity\AuthCode\AuthCode;
use App\OAuth\Entity\Scope\Scope;
use App\OAuth\Test\Entity\ClientBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class AuthCodeTest extends TestCase
{
    public function testCreate(): void
    {
        $code = new AuthCode();

        $code->setClient($client = (new ClientBuilder())->build());
        $code->addScope($scope = new Scope('common'));
        $code->setIdentifier($identifier = Uuid::uuid7()->toString());
        $code->setUserIdentifier($userIdentifier = Uuid::uuid7()->toString());
        $code->setExpiryDateTime($expiryDateTime = new DateTimeImmutable());
        $code->setRedirectUri($redirectUri = 'http://localhost/auth');

        self::assertSame($client, $code->getClient());
        self::assertSame([$scope], $code->getScopes());
        self::assertSame($identifier, $code->getIdentifier());
        self::assertSame($userIdentifier, $code->getUserIdentifier());
        self::assertSame($expiryDateTime, $code->getExpiryDateTime());
        self::assertSame($redirectUri, $code->getRedirectUri());
    }
}
