<?php

declare(strict_types=1);

namespace Test\Functional\V1\Authentication\Join;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;
use Test\Functional\Json;
use Test\Functional\WebTestCase;

final class RequestTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Чистим бд
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $connection = $container->get(Connection::class);
        $connection->executeQuery('TRUNCATE authentication_users');
        // Добавляем
        $connection->createQueryBuilder()
            ->insert('authentication_users')
            ->values(
                [
                    'id' => ':id',
                    'email' => ':email',
                ]
            )
            ->setParameter('id', '018d980e-c8f8-7015-ba0f-a3edff3243d5')
            ->setParameter('email', 'existing@lexusalex.tech')
            ->executeQuery();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        // Чистим бд
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $connection = $container->get(Connection::class);
        $connection->executeQuery('TRUNCATE authentication_users');
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
