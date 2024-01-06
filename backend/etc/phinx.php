<?php

declare(strict_types=1);


use function App\Configurations\Main\environment;

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/../src/Configurations/Migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/../src/Configurations/Seeds',
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'pgsql',
            'host' => environment('POSTGRES_HOST'),
            'name' => environment('POSTGRES_DB'),
            'user' => environment('POSTGRES_USER'),
            'pass' => environment('POSTGRES_PASSWORD'),
            'port' => environment('POSTGRES_PORT'),
            'charset' => environment('POSTGRES_CHARSET'),
        ],
    ],
    'version_order' => 'creation',
];