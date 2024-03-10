<?php

declare(strict_types=1);

namespace Test\Functional\OAuth\Fixtures\AuthorizationCode;

use Psr\Container\ContainerInterface;
use Test\Functional\Service\ConstructorFixtures;
use Test\Functional\Service\DataFixtures;

final class AuthorizeFixture
{
    private ConstructorFixtures $constructorFixtures;
    private DataFixtures $dataFixtures;
    public function __construct(ContainerInterface $container)
    {
        $this->constructorFixtures = $container->get(ConstructorFixtures::class);
        $this->dataFixtures = $container->get(DataFixtures::class);
    }

    public function load(): void
    {
        /** @var array{table:string, data:string[]} $userActive */
        $userActive = $this->dataFixtures->getUserActiveData();

        $this->constructorFixtures->insertSingleData(
            $userActive['table'],
            $userActive['data']
        );

        /** @var array{table:string, data:string[]} $userWait */
        $userWait = $this->dataFixtures->getUserWaitData();

        $this->constructorFixtures->insertSingleData(
            $userWait['table'],
            $userWait['data'],
            false
        );
    }
}
