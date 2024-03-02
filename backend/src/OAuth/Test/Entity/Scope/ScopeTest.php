<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\Scope;

use App\OAuth\Entity\Scope\Scope;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ScopeTest extends TestCase
{
    public function testCreate(): void
    {
        $scope = new Scope($identifier = 'common');

        self::assertSame($identifier, $scope->getIdentifier());
        self::assertSame($identifier, $scope->jsonSerialize());
    }

    public function testEmptyIdentifier(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Scope(''));
    }
}
