<?php

declare(strict_types=1);

namespace App\Authentication\Test\Command\JoinByEmail;

use App\Authentication\Entity\User\Types\Email;
use App\Authentication\Entity\User\Types\Id;
use App\Authentication\Entity\User\User;
use PHPUnit\Framework\TestCase;

final class RequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = User::requestJoinByEmail(
            $id = Id::generate(),
            $email = new Email('mail@example.com'),
            $hash = 'hash',
        );

        self::assertEquals($id, $user->getId());
        self::assertEquals($email, $user->getEmail());
        self::assertEquals($hash, $user->getPasswordHash());

    }
}
