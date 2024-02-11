<?php

declare(strict_types=1);

namespace App\Authentication\Entity\User;

use App\Authentication\Entity\User\Types\Email;
use App\Authentication\Entity\User\Types\Id;

final class User
{
    private Id $id;

    private Email $email;

    private function __construct(Id $id, Email $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public static function requestJoinByEmail(
        Id $id,
        Email $email
    ): self {
        return new self($id, $email);
    }
}
