<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\Client;

use App\OAuth\Entity\Client\Client;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 */
final class ClientTest extends TestCase
{
    public function testCreate(): void
    {
        $client = new Client(
            $identifier = Uuid::uuid7()->toString(),
            $name = 'Client',
            $redirectUri = 'http://localhost/auth'
        );


        self::assertSame($identifier, $client->getIdentifier());
        self::assertSame($name, $client->getName());
        self::assertSame($redirectUri, $client->getRedirectUri());

        self::assertFalse($client->isConfidential());
    }

    public function testEmptyIdentifier(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Client('', 'Client', 'http://localhost/auth'));
    }

    public function testEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Client(Uuid::uuid7()->toString(), '', 'http://localhost/auth'));
    }

    public function testEmptyRedirectUri(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Client(Uuid::uuid7()->toString(), 'Client', ''));
    }
}
