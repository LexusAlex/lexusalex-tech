<?php

declare(strict_types=1);

namespace App\Authentication\Entity\User;

use App\Authentication\Entity\User\Types\Id;

final class User
{
    private Id $id;

    private function __construct(Id $id)
    {
        $this->id = $id;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public static function requestJoinByEmail(
        Id $id,
    ): self {
        return new self($id);
    }
}
