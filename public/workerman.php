<?php

use DI\ContainerBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use Quatrevieux\Mvp\Core\Backend\WorkermanBackend;
use Quatrevieux\Mvp\Core\Runner;

use function DI\value;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Quatrevieux\Mvp\Core\Module\Application(
    [
        __DIR__ . '/../config/services.php',
        [
            'baseUrl' => value('http://127.0.0.1:8401/workerman'),
        ]
    ],
    new \Quatrevieux\Mvp\Backend\BaseModule(),
    new \Quatrevieux\Mvp\Backend\Chat\ChatModule(),
    new \Quatrevieux\Mvp\Backend\Blog\BlogModule(),
    new \Quatrevieux\Mvp\Backend\User\UserModule(),
    new \Quatrevieux\Mvp\Backend\BackOffice\BackOfficeModule(),
    new \Quatrevieux\Mvp\Backend\User\UserBackOfficeModule(),
);

$backend = new WorkermanBackend(
    $app->container->get(Psr17Factory::class),
    $app->runner(),
);

$worker = new \Workerman\Worker('http://0.0.0.0:5000');
$worker->count = 16;

\Workerman\Worker::$logFile = '/var/log/workerman.log';

$backend->start($worker);
