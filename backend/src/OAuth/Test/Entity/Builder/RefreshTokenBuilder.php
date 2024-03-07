<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\Builder;

use App\OAuth\Entity\AuthCode\AuthCode;
use App\OAuth\Entity\RefreshToken\RefreshToken;
use App\OAuth\Entity\Scope\Scope;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

final class RefreshTokenBuilder
{
    public function build(): RefreshToken
    {
        $token = new RefreshToken();

        $accessToken = (new AccessTokenBuilder())
            ->withUserIdentifier('018e13f4-7cdb-71a8-be03-ce8496c869c5')
            ->build((new ClientBuilder())->build());

        $token->setIdentifier('018e13f4-7cdb-71a8-be03-ce8496c869c5');
        $token->setExpiryDateTime(new DateTimeImmutable());
        $token->setAccessToken($accessToken);

        return $token;
    }
}
