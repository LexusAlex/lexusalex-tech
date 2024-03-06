<?php

declare(strict_types=1);

namespace Test\Functional\V1\Authentication\Join\Fixtures;

use Psr\Container\ContainerInterface;
use Test\Functional\Service\ConstructorFixtures;

final class RequestFixture
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
                'email' => 'existing@lexusalex.tech',
                'password_hash' => self::PASSWORD_HASH,
            ]
        );
    }
}
