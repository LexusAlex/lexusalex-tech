<?php

declare(strict_types=1);

namespace Test\Functional\OAuth\Entity\AuthCode;

use App\OAuth\Entity\AuthCode\AuthCodeRepository;
use App\OAuth\Test\Entity\Builder\AuthCodeBuilder;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use Psr\Container\ContainerInterface;
use Test\Functional\OAuth\Fixtures\AuthCodeRepositoryFixtureTruncate;
use Test\Functional\WebTestCase;

final class AuthCodeRepositoryTest extends WebTestCase
{
    public function testSuccess(): void
    {
        $code = new AuthCodeBuilder();

        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $repository = $container->get(AuthCodeRepository::class);

        $container->get(AuthCodeRepositoryFixtureTruncate::class)->load();
        $repository->persistNewAuthCode($code->build());

        $this->expectException(UniqueTokenIdentifierConstraintViolationException::class);
        $repository->persistNewAuthCode($code->build());

    }
}