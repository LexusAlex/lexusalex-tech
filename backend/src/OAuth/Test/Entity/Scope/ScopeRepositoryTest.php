<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\Scope;

use App\OAuth\Entity\Client\Client;
use App\OAuth\Entity\Scope\Scope;
use App\OAuth\Entity\Scope\ScopeRepository;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class ScopeRepositoryTest extends TestCase
{
    public function testCreate(): void
    {
        $scope = new Scope('common');
        $repository = new ScopeRepository([$scope]);
        $client = new Client(Uuid::uuid7()->toString(), 'Client', 'http://localhost/auth');
        $scopes = $repository->finalizeScopes([], 'common', $client);
        self::assertCount(0, $scopes);
    }
}
