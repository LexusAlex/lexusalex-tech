<?php

declare(strict_types=1);

namespace App\Authentication\Test\Entity\User\Types;

use App\Authentication\Entity\User\Types\Id;
use InvalidArgumentException;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class IdTest extends TestCase
{
    public function testSuccess(): void
    {
        $id = new Id($value = Uuid::uuid7()->toString());

        self::assertEquals($value, $id->getValue());
    }

    public function testCase(): void
    {
        $value = Uuid::uuid7()->toString();

        $id = new Id(mb_strtoupper($value));

        self::assertEquals($value, $id->getValue());
    }

    public function testGenerate(): void
    {
        $id = Id::generate();

        self::assertNotEmpty($id->getValue());
    }

    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Id('12345');
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Id('');
    }

    public function testToString(): void
    {
        $id = new Id(Uuid::uuid7()->toString());

        self::assertEquals((string) $id, $id->getValue());

    }
}
