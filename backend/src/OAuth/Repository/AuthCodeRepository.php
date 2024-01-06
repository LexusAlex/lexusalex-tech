<?php

declare(strict_types=1);

namespace App\OAuth\Repository;

use App\OAuth\Entity\AuthCode;
use Doctrine\DBAL\Connection;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

final class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    public function __construct(private readonly Connection $connection) {}
    public function getNewAuthCode(): AuthCode
    {
        return new AuthCode();
    }

    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity): void
    {
        if ($this->exists($authCodeEntity->getIdentifier())) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }

        // Сохранение нового кода
    }

    public function revokeAuthCode($codeId): void
    {
        // Удаление кода
    }

    public function isAuthCodeRevoked($codeId): bool
    {
        return !$this->exists($codeId);
    }

    private function exists(string $id): bool
    {
        return $this->connection->createQueryBuilder('t')
                ->select('COUNT(t.identifier)')
                ->andWhere('t.identifier = :identifier')
                ->setParameter(':identifier', $id)
                ->getQuery()->getSingleScalarResult() > 0;
    }
}
