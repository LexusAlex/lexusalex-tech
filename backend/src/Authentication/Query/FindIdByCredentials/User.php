<?php

declare(strict_types=1);

namespace App\Authentication\Query\FindIdByCredentials;

final class User
{
    public function __construct(
        public readonly string $id
    ) {}
}
