<?php

declare(strict_types=1);

namespace Test\Functional\OAuth;

use Psr\Container\ContainerInterface;
use Test\Functional\Json;
use Test\Functional\OAuth\Fixtures\AuthorizationCode\AuthorizeFixture;
use Test\Functional\OAuth\Fixtures\AuthorizationCode\AuthorizeFixtureTruncate;
use Test\Functional\OAuth\Service\PKCE;
use Test\Functional\WebTestCase;

final class AuthorizeTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $container->get(AuthorizeFixture::class)->load();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        /** @var ContainerInterface $container */
        $container = $this->application()->getContainer();
        $container->get(AuthorizeFixtureTruncate::class)->load();

    }
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
                'redirect_uri' => 'http://127.0.0.1/oauth',
                'scope' => 'common',
                'state' => 'sTaTe',
            ])
        ));

        self::assertEquals(400, $response->getStatusCode());
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
                'redirect_uri' => 'http://127.0.0.1/oauth',
                'scope' => 'common',
                'state' => 'sTaTe',
            ])
        ));

        self::assertEquals(200, $response->getStatusCode());
        self::assertNotEmpty($content = (string) $response->getBody());
        self::assertStringContainsString('<title>Tech</title>', $content);
    }

    public function testInvalidClient(): void
    {
        $response = $this->application()->handle(self::html(
            'GET',
            '/authorize?' . http_build_query([
                'response_type' => 'code',
                'client_id' => 'invalid',
                'redirect_uri' => 'http://127.0.0.1/oauth',
                'code_challenge' => PKCE::challenge(PKCE::verifier()),
                'code_challenge_method' => 'S256',
                'scope' => 'common',
                'state' => 'sTaTe',
            ])
        ));

        self::assertEquals(401, $response->getStatusCode());
        self::assertJson($content = (string) $response->getBody());

        $data = Json::decode($content);

        self::assertEquals([
            'error' => 'invalid_client',
            'error_description' => 'Client authentication failed',
            'message' => 'Client authentication failed',
        ], $data);
    }

    public function testAuthActiveUser(): void
    {
        $response = $this->application()->handle(self::html(
            'POST',
            '/authorize?' . http_build_query([
                'response_type' => 'code',
                'client_id' => 'frontend',
                'redirect_uri' => 'http://127.0.0.1/oauth',
                'code_challenge' => PKCE::challenge(PKCE::verifier()),
                'code_challenge_method' => 'S256',
                'scope' => 'common',
                'state' => 'sTaTe',
            ]),
            [
                'email' => 'aCTive@app.test',
                'password' => 'pass',
            ]
        ));


        self::assertEquals(302, $response->getStatusCode());
        self::assertNotEmpty($location = $response->getHeaderLine('Location'));

        /** @var array{query:string} $url */
        $url = parse_url($location);

        self::assertNotEmpty($url['query']);

        /** @var array{code:string,state:string} $query */
        parse_str($url['query'], $query);

        self::assertArrayHasKey('code', $query);
        self::assertNotEmpty($query['code']);
        self::assertArrayHasKey('state', $query);
        self::assertEquals('sTaTe', $query['state']);
    }

    /*
    public function testAuthWaitUser(): void
    {
        $response = $this->app()->handle(self::html(
            'POST',
            '/authorize?' . http_build_query([
                'response_type' => 'code',
                'client_id' => 'frontend',
                'redirect_uri' => 'http://localhost/oauth',
                'code_challenge' => PKCE::challenge(PKCE::verifier()),
                'code_challenge_method' => 'S256',
                'scope' => 'common',
                'state' => 'sTaTe',
            ]),
            [
                'email' => 'wait@app.test',
                'password' => 'password',
            ]
        ));

        self::assertEquals(409, $response->getStatusCode());
        self::assertNotEmpty($content = (string)$response->getBody());
        self::assertStringContainsString('User is not confirmed.', $content);
    }
    */

    public function testAuthInvalidUser(): void
    {
        $response = $this->application()->handle(self::html(
            'POST',
            '/authorize?' . http_build_query([
                'response_type' => 'code',
                'client_id' => 'frontend',
                'redirect_uri' => 'http://127.0.0.1/oauth',
                'code_challenge' => PKCE::challenge(PKCE::verifier()),
                'code_challenge_method' => 'S256',
                'scope' => 'common',
                'state' => 'sTaTe',
            ]),
            [
                'email' => 'active@app.test',
                'password' => '',
            ]
        ));

        self::assertEquals(400, $response->getStatusCode());
        self::assertNotEmpty($content = (string) $response->getBody());
        self::assertStringContainsString('Incorrect email or password.', $content);
    }

    public function testAttributeNotAllowed(): void
    {
        $response = $this->application()->handle(self::html(
            'POST',
            '/authorize?' . http_build_query([
                'response_type' => 'code',
                'client_id' => 'frontend',
                'redirect_uri' => 'http://127.0.0.1/oauth',
                'code_challenge' => PKCE::challenge(PKCE::verifier()),
                'code_challenge_method' => 'S256',
                'scope' => 'common',
                'state' => 'sTaTe',
            ]),
            [
                'email2' => 'active@app.test',
            ]
        ));

        self::assertEquals(422, $response->getStatusCode());
        self::assertNotEmpty($content = (string) $response->getBody());
        $data = Json::decode($content);

        self::assertEquals([
            'email2' => 'The attribute is not allowed.',
        ], $data['errors']);




    }
}
