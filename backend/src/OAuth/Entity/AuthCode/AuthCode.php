<?php

declare(strict_types=1);

namespace App\OAuth\Entity\AuthCode;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AuthCodeTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

/**
 * @psalm-suppress MissingConstructor
 * @psalm-suppress PossiblyUnusedProperty
 */
final class AuthCode implements AuthCodeEntityInterface
{
    use AuthCodeTrait;
    use EntityTrait;
    use TokenEntityTrait;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var DateTimeImmutable
     */
    protected $expiryDateTime;

    /**
     * @var string
     */
    protected $userIdentifier;
}
