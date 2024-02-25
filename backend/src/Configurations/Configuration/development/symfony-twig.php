<?php

declare(strict_types=1);

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Loader\FilesystemLoader;

use function App\Configurations\Main\environment;

return [
    Environment::class => static function (): Environment {

        $loader = new FilesystemLoader();
        $templates = [
            FilesystemLoader::MAIN_NAMESPACE => __DIR__ . '/../../Templates/twig',
        ];

        foreach ($templates as $alias => $dir) {
            $loader->addPath($dir, $alias);
        }

        $debug = environment('APPLICATION_DEBUG', '0');

        $environment = new Environment($loader, [
            'cache' => __DIR__ . '/../../var/cache/' . PHP_SAPI . '/twig',
            'debug' => $debug,
            'strict_variables' => $debug,
            'auto_reload' => $debug,
        ]);

        if ($debug) {
            $environment->addExtension(new DebugExtension());
        }


        //$extensions = [];

        //foreach ($extensions as $class) {
        /** @var ExtensionInterface $extension */
        //    $extension = $container->get($class);
        //    $environment->addExtension($extension);
        //}

        return $environment;
    },
];
