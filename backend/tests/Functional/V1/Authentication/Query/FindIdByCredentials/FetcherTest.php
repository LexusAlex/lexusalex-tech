<?php

declare(strict_types=1);

namespace Test\Functional\V1\Authentication\Query\FindIdByCredentials;

use App\Authentication\Query\FindIdByCredentials\Fetcher;
use App\Authentication\Query\FindIdByCredentials\Query;
use App\Authentication\Query\FindIdByCredentials\User;
use Psr\Container\ContainerInterface;
use Test\Functional\V1\Authentication\Query\FindIdByCredentials\Fixtures\FetcherFixture;
use Test\Functional\V1\Authentication\Query\FindIdByCredentials\Fixtures\FetcherFixtureTruncate;
use Test\Functional\V1\Authentication\Query\FindIdByCredentials\Fixtures\FetcherNullPasswordFixture;
use Test\Functional\WebTestCase;

final class FetcherTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $container->get(FetcherFixture::class)->load();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $container->get(FetcherFixtureTruncate::class)->load();
    }

    public function testFetchSuccess(): void
    {
        $query = new Query();
        $query->email = 'tech@lexusalex.tech';
        $query->password = 'pass';

        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $fetcher = $container->get(Fetcher::class);
        $user = $fetcher->fetch($query);

        self::assertInstanceOf(User::class, $user);
    }

    public function testFetchNotValidPassword(): void
    {
        $query = new Query();
        $query->email = 'tech@lexusalex.tech';
        $query->password = 'pass1';

        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $fetcher = $container->get(Fetcher::class);
        self::assertNull($fetcher->fetch($query));
    }

    public function testFetchEmptyPassword(): void
    {
        $query = new Query();
        $query->email = 'tech@lexusalex.tech';
        $query->password = 'pass';

        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $container->get(FetcherFixtureTruncate::class)->load();
        $container->get(FetcherNullPasswordFixture::class)->load();

        $fetcher = $container->get(Fetcher::class);
        self::assertNull($fetcher->fetch($query));
    }

    public function testFetchNotUser(): void
    {
        $query = new Query();
        $query->email = 'tech@lexusalex.tech1';
        $query->password = 'pass1';

        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $fetcher = $container->get(Fetcher::class);

        self::assertNull($fetcher->fetch($query));
    }

    public function testFetchUpperEmail(): void
    {
        $query = new Query();
        $query->email = 'Tech@LEXUSALEX.TECH';
        $query->password = 'pass';


        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $fetcher = $container->get(Fetcher::class);
        $user = $fetcher->fetch($query);
        self::assertInstanceOf(User::class, $user);
    }
}
