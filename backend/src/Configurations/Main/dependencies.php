<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

use function App\Configurations\Main\environment;

return static function (string $srcDir) {
    $modules = array_diff(scandir($srcDir), ['..', '.']);

    $configuration = [];
    /** @var string $module */
    foreach ($modules as $module) {
        $configuration[] = new PhpFileProvider($srcDir . "/{$module}/Configuration/common/*.php");
        $configuration[] = new PhpFileProvider($srcDir . "/{$module}/Configuration/" . environment('APPLICATION_ENVIRONMENT', 'production') . "/*.php");
    }

    $aggregator = new ConfigAggregator($configuration);

    return $aggregator->getMergedConfig();
};
