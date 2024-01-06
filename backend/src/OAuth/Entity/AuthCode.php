<?php

declare(strict_types=1);

namespace App\OAuth\Entity;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AuthCodeTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

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
