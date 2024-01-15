<?php

declare(strict_types=1);

namespace Test\Functional\OAuth;

use Test\Functional\WebTestCase;

final class AuthorizeTest extends WebTestCase
{
    public function testWithoutParams(): void
    {
        $response = $this->application()->handle(self::html('GET', '/authorize'));
        self::assertEquals(400, $response->getStatusCode());
    }

    public function testPageWithoutChallenge(): void
    {
        $response = $this->application()->handle(self::html(
            'GET',
            '/authorize?' . http_build_query([
                'response_type' => 'code',
                'client_id' => 'frontend',
                'redirect_uri' => 'http://localhost/oauth',
                'scope' => 'common',
                'state' => 'sTaTe',
            ])
        ));

        self::assertEquals(401, $response->getStatusCode());
        self::assertJson($content = (string) $response->getBody());

        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        self::assertEquals('invalid_client', $data['error']);
    }

    public function testPageWithChallenge(): void
    {
        $response = $this->application()->handle(self::html(
            'GET',
            '/authorize?' . http_build_query([
                'response_type' => 'code',
                'client_id' => 'frontend',
                'code_challenge' => PKCE::challenge(PKCE::verifier()),
                'code_challenge_method' => 'S256',
                'redirect_uri' => '/oauth',
                'scope' => 'common',
                'state' => 'sTaTe',
            ])
        ));

        self::assertEquals(200, $response->getStatusCode());
        self::assertNotEmpty($content = (string) $response->getBody());
        self::assertStringContainsString('authorize', $content);
    }
}
