<?php

declare(strict_types=1);

namespace App\OAuth\Entity;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;

final class RefreshToken implements RefreshTokenEntityInterface
{
    use EntityTrait;
    use RefreshTokenTrait;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var DateTimeImmutable
     */
    protected $expiryDateTime;

    private ?string $userIdentifier = null;

    public function setAccessToken(AccessTokenEntityInterface $accessToken): void
    {
        $this->accessToken = $accessToken;
        $this->userIdentifier = (string) $accessToken->getUserIdentifier();
    }

    public function getUserIdentifier(): ?string
    {
        return $this->userIdentifier;
    }
}
