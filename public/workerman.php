<?php

use DI\ContainerBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use Quatrevieux\Mvp\Core\Backend\WorkermanBackend;
use Quatrevieux\Mvp\Core\Runner;

use function DI\value;

require_once __DIR__ . '/../vendor/autoload.php';

$container = (new ContainerBuilder())
    ->addDefinitions(__DIR__ . '/../config/services.php')
    ->addDefinitions([
        'baseUrl' => value('http://127.0.0.1:5000'),
    ])
    ->build()
;

$backend = new WorkermanBackend(
    $container->get(Psr17Factory::class),
    $container->get(Runner::class),
);

$worker = new \Workerman\Worker('http://0.0.0.0:5000');
$worker->count = 16;

$backend->start($worker);
