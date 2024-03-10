<?php

declare(strict_types=1);

namespace Test\Functional\Service;

final class DataFixtures
{
    // pass
    private const PASSWORD_HASH = '$argon2i$v=19$m=16,t=4,p=1$TEEvQkF6dGRWZmRGbmFHNA$4ga3MX6bI5AnDNwfTUw3lTVmJlBggT9/fvjF4tOuxrM';
    public function getUserExistingData(): array
    {
        return [
            'table' => 'authentication_users',
            'data' => [
                'id' => '018d980e-c8f8-7015-ba0f-a3edff3243d5',
                'email' => 'existing@lexusalex.tech',
                'password_hash' => $this::PASSWORD_HASH,
            ],
        ];
    }

    public function getUserNormalData(): array
    {
        return [
            'table' => 'authentication_users',
            'data' => [
                'id' => '00000000-0000-0000-0000-000000000001',
                'email' => 'tech@lexusalex.tech',
                'password_hash' => $this::PASSWORD_HASH,
            ],
        ];
    }

    public function getUserActiveData(): array
    {
        return [
            'table' => 'authentication_users',
            'data' => [
                'id' => '018d980e-c8f8-7015-ba0f-a3edff3243d5',
                'email' => 'active@app.test',
                'password_hash' => $this::PASSWORD_HASH,
            ],
        ];
    }

    public function getUserWaitData(): array
    {
        return [
            'table' => 'authentication_users',
            'data' => [
                'id' => '018d980e-c8f8-7015-ba0f-a3edff3243d6',
                'email' => 'wait@app.test',
                'password_hash' => $this::PASSWORD_HASH,
            ],
        ];
    }

    public function getUserNullPasswordData(): array
    {
        return [
            'table' => 'authentication_users',
            'data' => [
                'id' => '00000000-0000-0000-0000-000000000001',
                'email' => 'tech@lexusalex.tech',
                'password_hash' => null,
            ],
        ];
    }

    public function getAuthCodeData(): array
    {
        return [
            'table' => 'oauth_auth_codes',
            'data' => [
                'identifier' => 'def50200f204dedbb244ce4539b9e',
                'expiry_date_time' => '2300-12-31 21:00:10',
                'user_identifier' => '00000000-0000-0000-0000-000000000001',
            ],
        ];
    }

    public function getRefreshTokenData(): array
    {
        return [
            'table' => 'oauth_refresh_tokens',
            'data' => [
                'identifier' => 'aef50200f204dedbb244ce4539b9e',
                'expiry_date_time' => '2300-12-31 21:00:10',
                'user_identifier' => '00000000-0000-0000-0000-000000000001',
            ],
        ];
    }

    public function truncateUser(): string
    {
        return 'TRUNCATE authentication_users';
    }

    public function truncateAuthCodes(): string
    {
        return 'TRUNCATE oauth_auth_codes';
    }

    public function truncateRefreshTokens(): string
    {
        return 'TRUNCATE oauth_refresh_tokens';
    }
}
