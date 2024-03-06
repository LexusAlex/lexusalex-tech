<?php

declare(strict_types=1);

namespace Test\Functional\OAuth\Fixtures;

use Psr\Container\ContainerInterface;
use Test\Functional\Service\ConstructorFixtures;

final class AuthorizeFixture
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
                'id' => '018d980e-c8f8-7015-ba0f-a3edff3243d5',
                'email' => 'active@app.test',
                'password_hash' => self::PASSWORD_HASH,
            ]
        );

        $this->constructorFixtures->insertSingleData(
            'authentication_users',
            [
                'id' => '018d980e-c8f8-7015-ba0f-a3edff3243d6',
                'email' => 'wait@app.test',
                'password_hash' => self::PASSWORD_HASH,
            ],
            false
        );
    }
}
