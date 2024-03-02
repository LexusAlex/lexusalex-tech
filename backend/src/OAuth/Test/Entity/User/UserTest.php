<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\User;

use App\OAuth\Entity\User\User;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class UserTest extends TestCase
{
    public function testCreate(): void
    {
        $user = new User($identifier = Uuid::uuid7()->toString());

        self::assertSame($identifier, $user->getIdentifier());
    }

    public function testEmptyIdentifier(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new User(''));
    }
}
