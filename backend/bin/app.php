#!/usr/bin/env php
<?php

declare(strict_types=1);

use App\Configurations\Cli\LoadFixturesCommand;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

require __DIR__ . '/../vendor/autoload.php';


/** @var ContainerInterface $container */
$dependencies = (require __DIR__ . '/../src/Configurations/Main/dependencies.php')(__DIR__ . '/../src');
$container = (require __DIR__ . '/../src/Configurations/Main/container.php')($dependencies);

$cli = new Application('Console');

$cli->add((new LoadFixturesCommand($container)));

$cli->run();
