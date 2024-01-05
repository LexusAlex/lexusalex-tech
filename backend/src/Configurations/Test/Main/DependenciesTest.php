<?php

declare(strict_types=1);

namespace App\Configurations\Test\Main;

use PHPUnit\Framework\TestCase;

final class DependenciesTest extends TestCase
{
    public function testSuccessDependencies(): void
    {
        $dependencies = (require __DIR__ . '/../../Main/dependencies.php')((__DIR__. '/src'));
        self::assertEquals(888, $dependencies['Test']);
    }

    public function testErrorDependencies(): void
    {
        $dependencies = (require __DIR__ . '/../../Main/dependencies.php')((__DIR__. '/src'));
        self::assertNotEquals(999, $dependencies['Test']);
    }
}
