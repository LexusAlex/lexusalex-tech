<?php

declare(strict_types=1);

namespace App\OAuth\Entity\RefreshToken;

use Doctrine\DBAL\Connection;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

final class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    public function getNewRefreshToken(): ?RefreshToken
    {
        return new RefreshToken();
    }

    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity): void
    {
        if ($this->exists($refreshTokenEntity->getIdentifier())) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }
    }

    public function revokeRefreshToken($tokenId): void
    {

        $result = $this->connection->createQueryBuilder()
                ->select('*')
                ->from('oauth_refresh_tokens')
                ->where('identifier = :identifier')
                ->setParameter('identifier', $tokenId)
                ->executeQuery()
                ->rowCount() > 0;

        if ($result) {
            $this->connection->createQueryBuilder()
                ->delete('oauth_refresh_tokens')
                ->where('identifier = :identifier')
                ->setParameter('identifier', $tokenId)
                ->executeStatement();
        }
    }

    public function isRefreshTokenRevoked($tokenId): bool
    {
        return !$this->exists($tokenId);
    }

    private function exists(string $id): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('*')
                ->from('oauth_refresh_tokens')
                ->where('identifier = :identifier')
                ->setParameter('identifier', $id)
                ->executeQuery()
                ->rowCount() > 0;
    }
}
