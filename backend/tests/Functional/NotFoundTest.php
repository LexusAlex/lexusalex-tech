<?php

declare(strict_types=1);

namespace Test\Functional;

final class NotFoundTest extends WebTestCase
{
    public function testNotFound(): void
    {
        $response = $this->application()->handle(self::json('GET', '/not-found'));

        self::assertEquals(404, $response->getStatusCode());
        self::assertJson($body = (string) $response->getBody());

        $data = Json::decode($body);

        self::assertEquals('404 Not Found', $data['message']);
    }
}
