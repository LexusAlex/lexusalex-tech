<?php

declare(strict_types=1);

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

use function App\Configurations\Main\environment;

return [
    Connection::class => static function (): Connection {
        $connectionParams = [
            'driver' => 'pdo_pgsql',
            'host' => environment('POSTGRES_HOST'),
            'user' => environment('POSTGRES_USER'),
            'password' => environment('POSTGRES_PASSWORD'),
            'dbname' => environment('POSTGRES_DB'),
            'charset' => environment('POSTGRES_CHARSET'),
        ];
        return DriverManager::getConnection($connectionParams);
    },
];
