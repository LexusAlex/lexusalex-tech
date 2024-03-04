<?php

declare(strict_types=1);

namespace App\Authentication\Command\JoinByEmail\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class Command
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email = '',
        #[Assert\PasswordStrength(minScore: Assert\PasswordStrength::STRENGTH_WEAK)]
        #[Assert\Length(min: 6)]
        #[Assert\NotBlank]
        public string $password = ''
    ) {}
}
