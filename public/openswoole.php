<?php

use OpenSwoole\Http\Server;
use Quatrevieux\Mvp\Core\Backend\OpenSwooleBackend;

use function DI\value;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Quatrevieux\Mvp\Core\Module\Application(
    [
        __DIR__ . '/../config/services.php',
        [
            'baseUrl' => value('http://127.0.0.1:8401/openswoole'),
        ]
    ],
    new \Quatrevieux\Mvp\Backend\BaseModule(),
    new \Quatrevieux\Mvp\Backend\Chat\ChatModule(),
    new \Quatrevieux\Mvp\Backend\Blog\BlogModule(),
    new \Quatrevieux\Mvp\Backend\User\UserModule(),
    new \Quatrevieux\Mvp\Backend\BackOffice\BackOfficeModule(),
    new \Quatrevieux\Mvp\Backend\User\UserBackOfficeModule(),
);

$backend = new OpenSwooleBackend($app->runner());

$server = new Server('0.0.0.0', 5000);
$server->set([
    'worker_num' => 16,      // The number of worker processes to start
    //'task_worker_num' => 8, // The amount of task workers to start
    'backlog' => 128,       // TCP backlog connection number
]);

$backend->start($server);
