<?php

declare(strict_types=1);

namespace Test\Functional\OAuth;

use App\OAuth\Entity\Scope\Scope;
use DateTimeImmutable;
use Defuse\Crypto\Crypto;
use Psr\Container\ContainerInterface;
use Test\Functional\Json;
use Test\Functional\OAuth\Fixtures\RefreshToken\RefreshTokenFixture;
use Test\Functional\OAuth\Fixtures\RefreshToken\RefreshTokenFixtureTruncate;
use Test\Functional\WebTestCase;

use function App\Configurations\Main\environment;

final class RefreshTokenTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $container->get(RefreshTokenFixture::class)->load();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $container->get(RefreshTokenFixtureTruncate::class)->load();
    }

    public function testSuccess(): void
    {
        $payload = [
            'client_id' => 'frontend',
            'refresh_token_id' => 'aef50200f204dedbb244ce4539b9e',
            'access_token_id' => '50200f204dedbb244ce453',
            'scopes' => [new Scope('common')],
            'user_id' => '00000000-0000-0000-0000-000000000001',
            'expire_time' => (new DateTimeImmutable('2300-12-31 21:00:10'))->getTimestamp(),
        ];

        $token = Crypto::encryptWithPassword(Json::encode($payload), environment('JWT_ENCRYPTION_KEY'));

        $response = $this->application()->handle(self::html('POST', '/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $token,
            'redirect_uri' => 'http://127.0.0.1/oauth',
            'client_id' => 'frontend',
            'access_type' => 'offline',
        ]));

        self::assertEquals(200, $response->getStatusCode());

        self::assertJson($content = (string) $response->getBody());

        $data = Json::decode($content);

        self::assertArrayHasKey('expires_in', $data);
        self::assertNotEmpty($data['expires_in']);

        self::assertArrayHasKey('access_token', $data);
        self::assertNotEmpty($data['access_token']);

        self::assertArrayHasKey('refresh_token', $data);
        self::assertNotEmpty($data['refresh_token']);
    }

    public function testUnknownError(): void
    {
        $payload = [
            'client_id' => 'frontend',
            'refresh_token_id' => 'aef50200f204dedbb244ce4539b9e',
            'access_token_id' => '50200f204dedbb244ce453',
            'scopes' => [new Scope('common')],
            'user_id' => '00000000-0000-0000-0000-0000000000017',
            'expire_time' => (new DateTimeImmutable('2300-12-31 21:00:10'))->getTimestamp(),
        ];

        $token = Crypto::encryptWithPassword(Json::encode($payload), environment('JWT_ENCRYPTION_KEY'));

        $response = $this->application()->handle(self::html('POST', '/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $token,
            'redirect_uri' => 'http://127.0.0.1/oauth',
            'client_id' => 'frontend',
        ]));

        self::assertEquals(500, $response->getStatusCode());
    }

    public function testError(): void
    {
        $payload = [
            'client_id' => 'frontend',
            'refresh_token_id' => 'aef50200f204dedbb244ce4539b9e',
            'access_token_id' => '50200f204dedbb244ce453',
            'scopes' => [new Scope('common')],
            'user_id' => '00000000-0000-0000-0000-000000000001',
            'expire_time' => (new DateTimeImmutable('2300-12-31 21:00:10'))->getTimestamp(),
        ];

        $token = Crypto::encryptWithPassword(Json::encode($payload), environment('JWT_ENCRYPTION_KEY'));

        $response = $this->application()->handle(self::html('POST', '/token', [
            'grant_type' => 'refresh_token1',
            'refresh_token' => $token,
            'redirect_uri' => 'http://127.0.0.1/oauth',
            'client_id' => 'frontend',
            'access_type' => 'offline',
        ]));

        self::assertEquals(400, $response->getStatusCode());
    }
}
