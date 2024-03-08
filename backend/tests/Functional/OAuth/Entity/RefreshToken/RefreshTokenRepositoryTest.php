<?php

declare(strict_types=1);

namespace Test\Functional\OAuth\Entity\RefreshToken;

use App\OAuth\Entity\RefreshToken\RefreshTokenRepository;
use App\OAuth\Test\Entity\Builder\RefreshTokenBuilder;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use Psr\Container\ContainerInterface;
use Test\Functional\OAuth\Fixtures\RefreshTokenFixtureTruncate;
use Test\Functional\WebTestCase;

final class RefreshTokenRepositoryTest extends WebTestCase
{
    public function testException(): void
    {
        $token = new RefreshTokenBuilder();
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $repository = $container->get(RefreshTokenRepository::class);

        $container->get(RefreshTokenFixtureTruncate::class)->load();
        $repository->persistNewRefreshToken($token->build());

        $this->expectException(UniqueTokenIdentifierConstraintViolationException::class);
        $repository->persistNewRefreshToken($token->build());
    }
}
