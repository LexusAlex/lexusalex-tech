<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\Client;

use App\OAuth\Entity\Client\Client;
use App\OAuth\Entity\Client\ClientRepository;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class ClientRepositoryTest extends TestCase
{
    public function testCreate(): void
    {
        $id = Uuid::uuid7()->toString();
        $client = new Client($id, 'Client', 'http://localhost/auth');
        $repository = new ClientRepository([$client]);

        self::assertNull($repository->getClientEntity('456456456'));

        self::assertTrue($repository->validateClient($id, null, 'common'));


    }
}
