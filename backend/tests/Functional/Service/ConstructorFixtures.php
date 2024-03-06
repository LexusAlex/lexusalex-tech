<?php

declare(strict_types=1);

namespace Test\Functional\Service;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;

final class ConstructorFixtures
{
    private Connection $connection;
    public function __construct(ContainerInterface $container)
    {
        $this->connection = $container->get(Connection::class);
    }

    public function insertSingleData(string $table, array $tableData): void
    {
        /**
         * @var array $values
         */
        $values = [];

        foreach (array_keys($tableData) as $data) {
            $values[$data] = ":$data";
        }

        $this->connection->createQueryBuilder()
            ->insert($table)
            ->values($values)
            ->setParameters($tableData)
            ->executeQuery();
    }
}
