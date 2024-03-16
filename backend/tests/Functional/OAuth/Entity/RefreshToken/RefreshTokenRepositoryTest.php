<?php

declare(strict_types=1);

namespace Test\Functional\OAuth\Entity\RefreshToken;

use App\OAuth\Entity\RefreshToken\RefreshTokenRepository;
use App\OAuth\Test\Entity\Builder\RefreshTokenBuilder;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use Psr\Container\ContainerInterface;
use Test\Functional\OAuth\Fixtures\RefreshToken\RefreshTokenFixtureTruncate;
use Test\Functional\WebTestCase;

final class RefreshTokenRepositoryTest extends WebTestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $container->get(RefreshTokenFixtureTruncate::class)->load();

    }

    public function testSuccess(): void
    {
        $token = (new RefreshTokenBuilder())->build();

        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $repository = $container->get(RefreshTokenRepository::class);

        $container->get(RefreshTokenFixtureTruncate::class)->load();
        $repository->persistNewRefreshToken($token);
        self::assertFalse($repository->isRefreshTokenRevoked((string) $token->getIdentifier()));
    }
    public function testException(): void
    {
        $token = (new RefreshTokenBuilder())->build();

        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $repository = $container->get(RefreshTokenRepository::class);
        $repository->persistNewRefreshToken($token);
        $this->expectException(UniqueTokenIdentifierConstraintViolationException::class);
        $repository->persistNewRefreshToken($token);
    }

    public function testRevokeSuccessRefreshToken(): void
    {
        $token = (new RefreshTokenBuilder())->build();
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $repository = $container->get(RefreshTokenRepository::class);
        $repository->persistNewRefreshToken($token);
        self::assertTrue($repository->revokeRefreshToken('aef50200f204dedbb244ce4539b9e'));
    }

    public function testRevokeFalseRefreshToken(): void
    {
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $repository = $container->get(RefreshTokenRepository::class);
        self::assertFalse($repository->revokeRefreshToken('aef50200f204dedbb244ce4539b9e'));
    }
}
