<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\Builder;

use App\OAuth\Entity\Scope\Scope;

final class ScopeBuilder
{
    public function build(): array
    {
        return [new Scope('common')];
    }
}
