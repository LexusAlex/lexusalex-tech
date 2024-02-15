#!/usr/bin/env php
<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

require __DIR__ . '/../vendor/autoload.php';


/** @var ContainerInterface $container */
$dependencies = (require __DIR__ . '/../src/Configurations/Main/dependencies.php')(__DIR__ . '/../src');
$container = (require __DIR__ . '/../src/Configurations/Main/container.php')($dependencies);

$cli = new Application('Console');

/**
 * @var string[] $commands
 * @psalm-suppress MixedArrayAccess
 */
$commands = $container->get('configurations')['symfony']['console']['commands'];

foreach ($commands as $name) {
    /** @var Command $command */
    $command = $container->get($name);
    $cli->add($command);
}
$cli->run();
