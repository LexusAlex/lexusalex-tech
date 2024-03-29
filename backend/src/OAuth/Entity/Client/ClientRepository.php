<?php

declare(strict_types=1);

namespace App\OAuth\Entity\Client;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

final class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @var Client[]
     */
    private array $clients;

    /**
     * @param Client[] $clients
     */
    public function __construct(array $clients)
    {
        $this->clients = $clients;
    }

    public function getClientEntity($clientIdentifier): ?Client
    {
        foreach ($this->clients as $client) {
            if ($client->getIdentifier() === $clientIdentifier) {
                return $client;
            }
        }

        return null;
    }

    public function validateClient($clientIdentifier, $clientSecret, $grantType): bool
    {
        return true;
    }
}
