<?php

declare(strict_types=1);

namespace Test\Functional\OAuth\Entity\AuthCode;

use App\OAuth\Entity\AuthCode\AuthCodeRepository;
use App\OAuth\Test\Entity\Builder\AuthCodeBuilder;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use Psr\Container\ContainerInterface;
use Test\Functional\OAuth\Fixtures\AuthCode\AuthCodeRepositoryFixtureTruncate;
use Test\Functional\WebTestCase;

final class AuthCodeRepositoryTest extends WebTestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $container->get(AuthCodeRepositoryFixtureTruncate::class)->load();

    }
    public function testSuccess(): void
    {
        $code = (new AuthCodeBuilder())->build();

        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $repository = $container->get(AuthCodeRepository::class);
        $repository->persistNewAuthCode($code);
        self::assertFalse($repository->isAuthCodeRevoked((string) $code->getIdentifier()));
    }

    public function testException(): void
    {
        $code = (new AuthCodeBuilder())->build();

        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $repository = $container->get(AuthCodeRepository::class);
        $repository->persistNewAuthCode($code);
        $this->expectException(UniqueTokenIdentifierConstraintViolationException::class);
        $repository->persistNewAuthCode($code);
    }

    public function testRevokeSuccessAuthCode(): void
    {
        $code = (new AuthCodeBuilder())->build();
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $repository = $container->get(AuthCodeRepository::class);
        $repository->persistNewAuthCode($code);
        self::assertTrue($repository->revokeAuthCode('018e13f4-7cdb-71a8-be03-ce8496c869c5'));
    }

    public function testRevokeFalseAuthCode(): void
    {
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $repository = $container->get(AuthCodeRepository::class);
        self::assertFalse($repository->revokeAuthCode('018e13f4-7cdb-71a8-be03-ce8496c869c5'));
    }
}
