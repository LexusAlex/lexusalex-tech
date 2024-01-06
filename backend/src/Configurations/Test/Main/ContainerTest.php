<?php

declare(strict_types=1);

namespace App\Configurations\Test\Main;

use DI\NotFoundException;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class ContainerTest extends TestCase
{
    public function testGetValue(): void
    {
        $dependencies = (require __DIR__ . '/../../Main/dependencies.php')((__DIR__ . '/src'));
        /**
         * @var ContainerInterface $container
         */
        $container = (require __DIR__ . '/../../Main/container.php')($dependencies);

        self::assertEquals(888, $container->get("Test"));
    }

    public function testNotFoundValue(): void
    {
        $dependencies = (require __DIR__ . '/../../Main/dependencies.php')((__DIR__ . '/src'));
        /**
         * @var ContainerInterface $container
         */
        $container = (require __DIR__ . '/../../Main/container.php')($dependencies);
        $this->expectException(NotFoundException::class);
        $container->get("Test5");

    }
}
