<?php

declare(strict_types=1);

use App\Authentication\Entity\User\UserRepository;
use App\OAuth\Entity\AccessToken\AccessTokenRepository;
use App\OAuth\Entity\AuthCode\AuthCodeRepository;
use App\OAuth\Entity\Client\Client;
use App\OAuth\Entity\Client\ClientRepository;
use App\OAuth\Entity\RefreshToken\RefreshTokenRepository;
use App\OAuth\Entity\Scope\Scope;
use App\OAuth\Entity\Scope\ScopeRepository;
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
use League\OAuth2\Server\ResourceServer;
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
    ResourceServer::class => static function (ContainerInterface $container): ResourceServer {
        return new ResourceServer(
            $container->get(AccessTokenRepositoryInterface::class),
            new CryptKey(environment('JWT_PUBLIC_KEY_PATH'), null, false)
        );
    },
    ScopeRepositoryInterface::class => static function (): ScopeRepository {

        return new ScopeRepository(
            [new Scope('common')]
        );
    },
    ClientRepositoryInterface::class => static function (): ClientRepository {
        return new ClientRepository(
            [new Client('frontend', 'frontend', environment('FRONTEND_URL') . '/oauth')]
        );
    },
    UserRepositoryInterface::class => DI\get(UserRepository::class),
    AccessTokenRepositoryInterface::class => DI\get(AccessTokenRepository::class),
    AuthCodeRepositoryInterface::class => DI\get(AuthCodeRepository::class),
    RefreshTokenRepositoryInterface::class => DI\get(RefreshTokenRepository::class),
];
