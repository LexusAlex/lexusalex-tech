<?php

declare(strict_types=1);

namespace Test\Functional\V1\Authentication\Query\FindIdByCredentials\Fixtures;

use Psr\Container\ContainerInterface;
use Test\Functional\Service\ConstructorFixtures;

final class FetcherNullPasswordFixture
{
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
                'email' => 'tech@lexusalex.tech',
                'password_hash' => '',
            ]
        );
    }
}
