<?php

declare(strict_types=1);

namespace App\Http\Middleware\Authenticate;

final class Identity
{
    public function __construct(
        public readonly string $id,
    ) {}
}
