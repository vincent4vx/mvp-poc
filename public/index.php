<?php

use DI\ContainerBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Quatrevieux\Mvp\Core\Backend\DefaultBackend;
use Quatrevieux\Mvp\Core\Runner;

require_once __DIR__ . '/../vendor/autoload.php';

//sleep(1);
usleep(500000);

$app = new \Quatrevieux\Mvp\Core\Module\Application(
    [
        __DIR__ . '/../config/services.php',
    ],
    new \Quatrevieux\Mvp\Backend\BaseModule(),
    new \Quatrevieux\Mvp\Backend\Chat\ChatModule(),
    new \Quatrevieux\Mvp\Backend\Blog\BlogModule(),
    new \Quatrevieux\Mvp\Backend\User\UserModule(),
    new \Quatrevieux\Mvp\Backend\BackOffice\BackOfficeModule(),
    new \Quatrevieux\Mvp\Backend\User\UserBackOfficeModule(),
);

$factory = $app->container->get(Psr17Factory::class);
$runner = $app->runner();

$creator = new ServerRequestCreator(
    $factory,
    $factory,
    $factory,
    $factory
);

$backend = new DefaultBackend($creator, $runner);
$backend->run();
