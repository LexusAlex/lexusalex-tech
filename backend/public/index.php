<?php

declare(strict_types=1);

http_response_code(500);

require __DIR__ . '/../vendor/autoload.php';

$dependencies = (require __DIR__ . '/../src/Configurations/Main/dependencies.php')((__DIR__. '/../src'));

$container = (require __DIR__ . '/../src/Configurations/Main/container.php')($dependencies);

$application = (require __DIR__ . '/../src/Configurations/Main/application.php')($container);

$application->run();