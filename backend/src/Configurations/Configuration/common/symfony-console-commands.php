<?php

declare(strict_types=1);

use App\Configurations\Cli\LoadFixturesCommand;

return [
    'configurations' => [
        'symfony' => [
            'console' => [
                'commands' => [
                    LoadFixturesCommand::class,
                ],
            ],
        ],
    ],
];
