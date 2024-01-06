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
use Doctrine\DBAL\Connection;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Psr\Container\ContainerInterface;

use function App\Configurations\Main\environment;

return [
    AuthorizationServer::class => static function (ContainerInterface $container): AuthorizationServer {

        $clientRepository = $container->get(ClientRepositoryInterface::class);
        $scopeRepository = $container->get(ScopeRepositoryInterface::class);
        $accessTokenRepository = $container->get(AccessTokenRepositoryInterface::class);
        $authCodeRepository = $container->get(AuthCodeRepositoryInterface::class);
        $refreshTokenRepository = $container->get(RefreshTokenRepositoryInterface::class);

        $server = new AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            new CryptKey(environment('JWT_PRIVATE_KEY_PATH'), null, false),
            environment('JWT_ENCRYPTION_KEY')
        );

        $grant = new AuthCodeGrant(
            $authCodeRepository,
            $refreshTokenRepository,
            new DateInterval('PT1M')
        );
        $grant->setRefreshTokenTTL(new DateInterval('P7D'));
        $server->enableGrantType($grant, new DateInterval('PT10M'));

        $grant = new RefreshTokenGrant($refreshTokenRepository);
        $grant->setRefreshTokenTTL(new DateInterval('P7D'));
        $server->enableGrantType($grant, new DateInterval('PT10M'));

        return $server;
    },
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
    AuthCodeRepository::class => static function (ContainerInterface $container): AuthCodeRepository {
        $connection = $container->get(Connection::class);
        return new AuthCodeRepository($connection);
    },
    RefreshTokenRepositoryInterface::class => DI\get(RefreshTokenRepository::class),
    RefreshTokenRepository::class => static function (ContainerInterface $container): RefreshTokenRepository {
        $connection = $container->get(Connection::class);
        return new RefreshTokenRepository($connection);
    },
];
