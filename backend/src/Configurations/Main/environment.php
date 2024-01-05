<?php

declare(strict_types=1);

namespace App\Configurations\Main;

use RuntimeException;

function environment(string $name, ?string $default = null): string
{
    $value = getenv($name);

    if (false !== $value) {
        return $value;
    }

    if (null !== $default) {
        return $default;
    }

    throw new RuntimeException('Undefined environment variable ' . $name);
}
