<?php

declare(strict_types=1);

namespace Test\Functional\V1\Authentication\User\Service;

use App\OAuth\Entity\AccessToken\AccessToken;
use App\OAuth\Entity\Client\Client;
use App\OAuth\Entity\Scope\Scope;

use DateTimeImmutable;
use League\OAuth2\Server\CryptKey;

use function App\Configurations\Main\environment;

final class AuthHeader
{
    public static function for(string $userId): string
    {
        $token = new AccessToken(
            new Client(
                identifier: 'frontend',
                name: 'tech',
                redirectUri: 'http://localhost:8080/oauth'
            ),
            [new Scope('common')],
        );
        $token->setIdentifier(bin2hex(random_bytes(40)));
        $token->setExpiryDateTime(new DateTimeImmutable('+1000 years'));
        $token->setUserIdentifier($userId);
        $token->setPrivateKey(new CryptKey(environment('JWT_PRIVATE_KEY_PATH'), null, false));

        return 'Bearer ' . $token;
    }
}
