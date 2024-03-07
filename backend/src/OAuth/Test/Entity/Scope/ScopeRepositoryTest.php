<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\Scope;

use App\OAuth\Entity\Scope\Scope;
use App\OAuth\Entity\Scope\ScopeRepository;
use App\OAuth\Test\Entity\Builder\ClientBuilder;
use App\OAuth\Test\Entity\Builder\ScopeBuilder;
use PHPUnit\Framework\TestCase;

final class ScopeRepositoryTest extends TestCase
{
    public function testCreate(): void
    {
        /** @var array<array-key, Scope> $scope */
        $scope = (new ScopeBuilder())->build();
        $repository = new ScopeRepository($scope);
        $client = (new ClientBuilder())->build();
        $scopes = $repository->finalizeScopes([], 'common', $client);
        $scopeNull = $repository->getScopeEntityByIdentifier('common1');
        self::assertCount(0, $scopes);
        self::assertNull($scopeNull);
    }
}
