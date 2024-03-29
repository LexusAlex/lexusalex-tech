<?php

declare(strict_types=1);

namespace App\OAuth\Test\Entity\Builder;

use App\OAuth\Entity\Client\Client;
use Ramsey\Uuid\Uuid;

final class ClientBuilder
{
    private string $identifier;
    private string $name;
    private string $redirectUri;

    public function __construct()
    {
        $this->identifier = Uuid::uuid7()->toString();
        $this->name = 'Client';
        $this->redirectUri = 'http://localhost:8080/auth';
    }

    public function build(): Client
    {
        return new Client(
            $this->identifier,
            $this->name,
            $this->redirectUri,
        );
    }
}
