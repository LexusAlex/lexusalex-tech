<?php

declare(strict_types=1);

namespace Test\Functional\V1\Authentication\User\Fixtures;

use Psr\Container\ContainerInterface;
use Test\Functional\Service\ConstructorFixtures;
use Test\Functional\Service\DataFixtures;

final class UserFixture
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
        /** @var array{table:string, data:string[]} $user */
        $user = $this->dataFixtures->getUserNormalData();

        $this->constructorFixtures->insertSingleData(
            $user['table'],
            $user['data']
        );
    }
}
