<?php

declare(strict_types=1);

use App\OAuth\Entity\Client;
use App\OAuth\Entity\Scope;
use App\OAuth\Repository\AccessTokenRepository;
use App\OAuth\Repository\AuthCodeRepository;
use App\OAuth\Repository\ClientRepository;
use App\OAuth\Repository\RefreshTokenRepository;
use App\OAuth\Repository\ScopeRepository;
use App\OAuth\Repository\UserRepository;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Psr\Container\ContainerInterface;

return [
    ScopeRepositoryInterface::class => static function (ContainerInterface $container): ScopeRepository {

        return new ScopeRepository(
            array_map(static fn(string $item): Scope => new Scope($item), [
                'common',
            ], )
        );
    },
    ClientRepositoryInterface::class => static function (ContainerInterface $container): ClientRepository {

        return new ClientRepository(
            array_map(static function (array $item): Client {
                return new Client(
                    $item['client_id'],
                    $item['name'],
                    $item['redirect_uri']
                );
            }, [
                [
                    'name' => 'tech',
                    'client_id' => 'frontend',
                    'redirect_uri' => '/oauth',
                ],
            ], )
        );
    },
    UserRepositoryInterface::class => DI\get(UserRepository::class),
    AccessTokenRepositoryInterface::class => DI\get(AccessTokenRepository::class),
    AuthCodeRepositoryInterface::class => DI\get(AuthCodeRepository::class),
    RefreshTokenRepositoryInterface::class => DI\get(RefreshTokenRepository::class),
];
