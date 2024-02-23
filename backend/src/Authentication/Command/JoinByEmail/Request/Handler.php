<?php

declare(strict_types=1);

namespace App\Authentication\Command\JoinByEmail\Request;

use App\Authentication\Entity\User\Types\Email;
use App\Authentication\Entity\User\Types\Id;
use App\Authentication\Entity\User\User;
use App\Authentication\Entity\User\UserRepository;
use App\Authentication\Service\PasswordHasher;
use DomainException;

final class Handler
{
    public function __construct(
        private readonly UserRepository $users,
        private readonly PasswordHasher $hasher,
    ) {}
    public function handle(Command $command): void
    {
        $email = new Email($command->email);

        if ($this->users->hasByEmail($email)) {
            throw new DomainException('User already exists.');
        }

        $user = User::requestJoinByEmail(
            Id::generate(),
            $email,
            $this->hasher->hash($command->password),
        );

        $this->users->add($user);
    }
}
