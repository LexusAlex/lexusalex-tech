<?php

declare(strict_types=1);

namespace App\OAuth\Entity\AuthCode;

use Doctrine\DBAL\Connection;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

final class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    public function getNewAuthCode(): AuthCode
    {
        return new AuthCode();
    }

    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity): void
    {

        // Существует ли такой идентификатор
        if ($this->exists($authCodeEntity->getIdentifier())) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }

        $this->connection->createQueryBuilder()
            ->insert('oauth_auth_codes')
            ->values(
                [
                    'identifier' => ':identifier',
                    'expiry_date_time' => ':expiry_date_time',
                    'user_identifier' => ':user_identifier',
                ]
            )
            ->setParameter('identifier', $authCodeEntity->getIdentifier())
            ->setParameter('expiry_date_time', $authCodeEntity->getExpiryDateTime()->format(DATE_ATOM))
            ->setParameter('user_identifier', $authCodeEntity->getUserIdentifier())
            ->executeQuery();
    }

    public function revokeAuthCode($codeId): bool
    {
        if ($this->exists($codeId)) {
            return (bool) $this->connection->createQueryBuilder()
                ->delete('oauth_auth_codes')
                ->where('identifier = :identifier')
                ->setParameter('identifier', $codeId)
                ->executeStatement();
        }

        return false;
    }

    public function isAuthCodeRevoked($codeId): bool
    {
        return !$this->exists($codeId);
    }

    private function exists(string $id): bool
    {
        return $this->connection->createQueryBuilder()
            ->select('identifier')
            ->from('oauth_auth_codes')
            ->where('identifier = :identifier')
            ->setParameter('identifier', $id)
            ->executeQuery()
            ->rowCount() > 0;
    }
}
