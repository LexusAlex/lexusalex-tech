<?php

declare(strict_types=1);

namespace App\Authentication\Entity\User\Types;

use Webmozart\Assert\Assert;

final class Email
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::email($value);
        $this->value = strtolower($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
