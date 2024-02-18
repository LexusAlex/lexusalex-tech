<?php

declare(strict_types=1);

namespace Test\Functional\V1\Authentication\Join;

use App\Authentication\Entity\User\Types\Email;
use App\Authentication\Entity\User\UserRepository;
use Psr\Container\ContainerInterface;
use Test\Functional\Json;
use Test\Functional\V1\Authentication\Join\Fixtures\RequestFixture;
use Test\Functional\V1\Authentication\Join\Fixtures\RequestFixtureTruncate;
use Test\Functional\WebTestCase;

final class RequestTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $container->get(RequestFixture::class)->load();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $container->get(RequestFixtureTruncate::class)->load();

    }

    public function testMethod(): void
    {
        $response = $this->application()->handle(self::json('GET', '/v1/authentication/join'));

        self::assertEquals(405, $response->getStatusCode());
    }

    public function testSuccess(): void
    {
        $response = $this->application()->handle(self::json('POST', '/v1/authentication/join', [
            'email' => 'new-user@lexusalex.tech',
            'password' => 'new-password',
        ]));

        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();

        self::assertTrue($container->get(UserRepository::class)->hasByEmail(new Email('new-user@lexusalex.tech')));
        self::assertEquals(201, $response->getStatusCode());
        self::assertEquals('', (string) $response->getBody());

    }

    public function testExisting(): void
    {
        $response = $this->application()->handle(self::json('POST', '/v1/authentication/join', [
            'email' => 'existing@lexusalex.tech',
            'password' => 'new-password',
        ]));

        self::assertEquals(409, $response->getStatusCode());
        self::assertJson($body = (string) $response->getBody());

        self::assertEquals([
            'message' => 'User already exists.',
        ], Json::decode($body));
    }

}
