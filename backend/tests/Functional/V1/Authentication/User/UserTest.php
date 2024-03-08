<?php

declare(strict_types=1);

namespace Test\Functional\V1\Authentication\User;

use Psr\Container\ContainerInterface;
use Test\Functional\Json;
use Test\Functional\V1\Authentication\User\Fixtures\UserFixture;
use Test\Functional\V1\Authentication\User\Service\AuthHeader;
use Test\Functional\WebTestCase;

final class UserTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $container->get(UserFixture::class)->load();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $container->get(Fixtures\UserFixtureTruncate::class)->load();

    }

    public function testGuest(): void
    {
        $response = $this->application()->handle(self::json('GET', '/v1/authentication/user'));

        self::assertEquals(401, $response->getStatusCode());
    }


    public function testSuccess(): void
    {
        $response = $this->application()->handle(
            self::json('GET', '/v1/authentication/user')
                ->withHeader('Authorization', AuthHeader::for('00000000-0000-0000-0000-000000000001'))
        );


        self::assertEquals(200, $response->getStatusCode());
        self::assertJson($body = (string) $response->getBody());

        self::assertEquals([
            'id' => '00000000-0000-0000-0000-000000000001',
        ], Json::decode($body));
    }

}
