<?php

use Michelf\Markdown;
use Michelf\MarkdownInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Quatrevieux\Mvp\App\CustomViewContextFactory;
use Quatrevieux\Mvp\Core\Dispatcher;
use Quatrevieux\Mvp\Core\View;
use Quatrevieux\Mvp\Core\Renderer;
use Quatrevieux\Mvp\Core\RendererFactoryInterface;
use Quatrevieux\Mvp\Core\RendererInterface;
use Quatrevieux\Mvp\Core\Router;

use Quatrevieux\Mvp\Core\ViewContextFactoryInterface;

use function DI\create;
use function DI\get;

return [
    'routes' => require __DIR__ . '/routes.php',
    'controllers' => require __DIR__ . '/controllers.php',
    'db' => require __DIR__ . '/db.php',
    'templates' => require __DIR__ . '/templates.php',

    Router::class => create()->constructor(get('routes')),
    Dispatcher::class => create()->constructor(
        get(Psr\Container\ContainerInterface::class),
        get('controllers')
    ),
    PDO::class => function (ContainerInterface $container) {
        $config = $container->get('db');

        return new PDO(
            $config['dsn'],
            $config['username'],
            $config['password'],
        );
    },
    Psr17Factory::class => create(),
    ResponseFactoryInterface::class => get(Psr17Factory::class),
    StreamFactoryInterface::class => get(Psr17Factory::class),
    RendererFactoryInterface::class => function (ContainerInterface $container) {
        return new class ($container) implements RendererFactoryInterface {
            public function __construct(
                private readonly ContainerInterface $container,
            ) {
            }

            public function forTemplate(string $template): RendererInterface
            {
                if (is_subclass_of($template, RendererInterface::class)) {
                    return $this->container->get($template);
                }

                return new Renderer(
                    $this->container->get(Router::class),
                    $template,
                );
            }
        };
    },
    ViewContextFactoryInterface::class => create(CustomViewContextFactory::class),
    View::class => create()->constructor(
        get(ResponseFactoryInterface::class),
        get(StreamFactoryInterface::class),
        get(RendererFactoryInterface::class),
        get(ViewContextFactoryInterface::class),
        get('templates'),
    ),
    MarkdownInterface::class => create(Markdown::class),
];
