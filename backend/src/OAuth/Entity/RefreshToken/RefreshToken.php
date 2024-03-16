<?php

declare(strict_types=1);

namespace App\OAuth\Entity\RefreshToken;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;

/**
 * @psalm-suppress MissingConstructor
 */
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
        /** @var string $userIdentifier */
        $userIdentifier = $accessToken->getUserIdentifier();
        $this->accessToken = $accessToken;
        $this->userIdentifier = $userIdentifier;
    }

    public function getUserIdentifier(): ?string
    {
        return $this->userIdentifier;
    }
}
