<?php

declare(strict_types=1);

namespace App\Authentication\Command\JoinByEmail\Request;

use App\Authentication\Entity\User\Types\Id;
use App\Authentication\Entity\User\User;

final class Handler
{
    public function handle(Command $command): void
    {
        $user = User::requestJoinByEmail(
            Id::generate(),
        );
    }
}
