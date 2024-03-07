<?php

declare(strict_types=1);

namespace Test\Functional\OAuth\Fixtures;

use App\OAuth\Entity\Client\Client;
use App\OAuth\Entity\RefreshToken\RefreshToken;
use App\OAuth\Test\Entity\Builder\AccessTokenBuilder;
use DateTimeImmutable;
use Psr\Container\ContainerInterface;
use Test\Functional\Service\ConstructorFixtures;

final class RefreshTokenFixture
{
    // pass
    private const PASSWORD_HASH = '$argon2i$v=19$m=16,t=4,p=1$TEEvQkF6dGRWZmRGbmFHNA$4ga3MX6bI5AnDNwfTUw3lTVmJlBggT9/fvjF4tOuxrM';
    private ConstructorFixtures $constructorFixtures;
    public function __construct(ContainerInterface $container)
    {
        $this->constructorFixtures = $container->get(ConstructorFixtures::class);
    }

    public function load(): void
    {

        $this->constructorFixtures->insertSingleData(
            'authentication_users',
            [
                'id' => '00000000-0000-0000-0000-000000000001',
                'email' => 'active@app.test',
                'password_hash' => self::PASSWORD_HASH,
            ]
        );


        $client = new Client(
            identifier: 'frontend',
            name: 'Frontend',
            redirectUri: 'http://localhost/oauth',
        );

        $accessToken = (new AccessTokenBuilder())
            ->withUserIdentifier('00000000-0000-0000-0000-000000000001')
            ->build($client);

        $refreshToken = new RefreshToken();
        $refreshToken->setAccessToken($accessToken);
        $refreshToken->setExpiryDateTime(new DateTimeImmutable('2300-12-31 21:00:10'));
        $refreshToken->setIdentifier('aef50200f204dedbb244ce4539b9e');


        $this->constructorFixtures->insertSingleData(
            'oauth_refresh_tokens',
            [
                'identifier' => 'aef50200f204dedbb244ce4539b9e',
                'expiry_date_time' => '2300-12-31 21:00:10',
                'user_identifier' => '00000000-0000-0000-0000-000000000001',
            ]
        );
    }
}
