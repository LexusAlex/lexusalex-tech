<?php

declare(strict_types=1);

namespace Test\Functional\V1\Authentication\Join;

use App\Authentication\Entity\User\Types\Email;
use App\Authentication\Entity\User\UserRepository;
use App\Authentication\Service\PasswordHasher;
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

        $email = new Email('new-user@lexusalex.tech');

        self::assertTrue($container->get(UserRepository::class)->hasByEmail($email));
        /**
         * @psalm-var array{id :string,email: string, password_hash: string} $user
         */
        $user = $container->get(UserRepository::class)->getUserByEmail($email);
        $password_hasher = new PasswordHasher();
        self::assertTrue($password_hasher->validate('new-password', $user['password_hash']));

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

    public function testEmptyBody(): void
    {
        $response = $this->application()->handle(self::json('POST', '/v1/authentication/join', []));

        self::assertEquals(422, $response->getStatusCode());

        self::assertJson($body = (string) $response->getBody());

        self::assertEquals([
            'errors' => [
                'email' => 'This value should not be blank.',
                'password' => 'This value should not be blank.',
            ],
        ], Json::decode($body));
    }

    public function testEmptyFields(): void
    {
        $response = $this->application()->handle(self::json('POST', '/v1/authentication/join', [
            'email' => '',
            'password' => '',
        ]));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string) $response->getBody());

        self::assertEquals([
            'errors' => [
                'email' => 'This value should not be blank.',
                'password' => 'This value should not be blank.',
            ],
        ], Json::decode($body));
    }

    public function testNotValid(): void
    {
        $response = $this->application()->handle(self::json('POST', '/v1/authentication/join', [
            'email' => 'not-email',
            'password' => 'new',
        ]));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string) $response->getBody());

        self::assertEquals([
            'errors' => [
                'email' => 'This value is not a valid email address.',
                'password' => 'This value is too short. It should have 6 characters or more.',
            ],
        ], Json::decode($body));
    }

    public function testNotExistingFields(): void
    {
        $response = $this->application()->handle(self::json('POST', '/v1/authentication/join', [
            'email' => 'existing@app.test',
            'password' => 'new-password',
            'age' => 42,
        ]));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string) $response->getBody());

        self::assertEquals([
            'errors' => [
                'age' => 'The attribute is not allowed.',
            ],
        ], Json::decode($body));
    }

}
