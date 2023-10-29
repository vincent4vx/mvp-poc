<?php

use DI\ContainerBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Quatrevieux\Mvp\Core\Backend\DefaultBackend;
use Quatrevieux\Mvp\Core\Runner;

require_once __DIR__ . '/../vendor/autoload.php';

//sleep(1);
//usleep(500000);

$container = (new ContainerBuilder())
    ->addDefinitions(
        __DIR__ . '/../config/services.php',
        __DIR__ . '/../config/adapters.php',
    )
    ->build()
;


$factory = $container->get(Psr17Factory::class);
$runner = $container->get(Runner::class);

$creator = new ServerRequestCreator(
    $factory,
    $factory,
    $factory,
    $factory
);

$backend = new DefaultBackend($creator, $runner);
$backend->run();
