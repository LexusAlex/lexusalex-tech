<?php

declare(strict_types=1);

namespace Test\Functional\OAuth;

use DateTimeImmutable;
use Defuse\Crypto\Crypto;
use Test\Functional\WebTestCase;

use function App\Configurations\Main\environment;

final class AuthorizationCodeTest extends WebTestCase
{
    public function testSuccess(): void
    {
        $verifier = PKCE::verifier();
        $challenge = PKCE::challenge($verifier);

        $payload = [
            'client_id' => 'frontend',
            'redirect_uri' => 'http://localhost/oauth',
            'auth_code_id' => 'def50200f204dedbb244ce4539b9e',
            'scopes' => 'common',
            'user_id' => '00000000-0000-0000-0000-000000000001',
            'expire_time' => (new DateTimeImmutable('2300-12-31 21:00:10'))->getTimestamp(),
            'code_challenge' => $challenge,
            'code_challenge_method' => 'S256',
        ];

        $code = Crypto::encryptWithPassword(json_encode($payload, JSON_THROW_ON_ERROR), environment('JWT_ENCRYPTION_KEY'));

        $response = $this->application()->handle(self::html('POST', '/token', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => 'http://localhost/oauth',
            'client_id' => 'frontend',
            'code_verifier' => $verifier,
            'access_type' => 'offline',
        ]));

        self::assertEquals(200, $response->getStatusCode());

        self::assertJson($content = (string) $response->getBody());

        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);



        self::assertArrayHasKey('expires_in', $data);
        self::assertNotEmpty($data['expires_in']);

        self::assertArrayHasKey('access_token', $data);
        self::assertNotEmpty($data['access_token']);

        self::assertArrayHasKey('refresh_token', $data);
        self::assertNotEmpty($data['refresh_token']);
    }
}
