<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\Builder;

use App\OAuth\Entity\RefreshToken\RefreshToken;
use DateTimeImmutable;

final class RefreshTokenBuilder
{
    public function build(): RefreshToken
    {
        $token = new RefreshToken();

        $accessToken = (new AccessTokenBuilder())
            ->withUserIdentifier('018e13f4-7cdb-71a8-be03-ce8496c869c5')
            ->build((new ClientBuilder())->build());

        $token->setIdentifier('aef50200f204dedbb244ce4539b9e');
        $token->setExpiryDateTime(new DateTimeImmutable());
        $token->setAccessToken($accessToken);

        return $token;
    }
}
