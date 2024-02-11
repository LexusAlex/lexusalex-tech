<?php

declare(strict_types=1);

namespace Test\Functional\V1\Authentication\Join;

use Test\Functional\Json;
use Test\Functional\WebTestCase;

final class RequestTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
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

        $this->removeTestUser();
    }

    public function testExisting(): void
    {
        $response = $this->application()->handle(self::json('POST', '/v1/authentication/join', [
            'email' => 'user@lexusalex.tech',
            'password' => 'new-password',
        ]));

        self::assertEquals(409, $response->getStatusCode());
        self::assertJson($body = (string) $response->getBody());

        self::assertEquals([
            'message' => 'User already exists.',
        ], Json::decode($body));
    }

}
