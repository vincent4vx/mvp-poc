<?php

use Michelf\Markdown;
use Michelf\MarkdownInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Quatrevieux\Mvp\Backend\User\UserSessionSerializer;
use Quatrevieux\Mvp\Core\AttributeControllerLoader;
use Quatrevieux\Mvp\Core\AttributeRouterLoader;
use Quatrevieux\Mvp\Core\CookieToken;
use Quatrevieux\Mvp\Core\Dispatcher;
use Quatrevieux\Mvp\Core\Firewall;
use Quatrevieux\Mvp\Core\QueryValidator;
use Quatrevieux\Mvp\Core\Renderer;
use Quatrevieux\Mvp\Core\RendererFactoryInterface;
use Quatrevieux\Mvp\Core\RendererInterface;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\SessionHandler;
use Quatrevieux\Mvp\Core\SessionResolverInterface;
use Quatrevieux\Mvp\Core\SessionSerializerInterface;
use Quatrevieux\Mvp\Core\SessionTokenInterface;
use Quatrevieux\Mvp\Core\SignedTokenResolver;
use Quatrevieux\Mvp\Core\View;
use Quatrevieux\Mvp\Core\ViewContextFactoryInterface;
use Quatrevieux\Mvp\Frontend\CustomViewContextFactory;
use Quatrevieux\Mvp\Frontend\LayoutRenderer;

use function DI\create;
use function DI\get;
use function DI\value;

return [
    'routes' => require __DIR__ . '/routes.php',
    'controllers' => require __DIR__ . '/controllers.php',
    'db' => require __DIR__ . '/db.php',
    'templates' => require __DIR__ . '/templates.php',
    'accessmap' => value(require __DIR__ . '/accessmap.php'),
    'baseUrl' => value('http://127.0.0.1/micro-mvp'),
    'assetsUrl' => value('http://127.0.0.1/micro-mvp/assets'),

    AttributeRouterLoader::class => create()->constructor(
        'Quatrevieux\\Mvp\\Backend\\',
        get('baseUrl'),
    ),
    AttributeControllerLoader::class => create()->constructor('Quatrevieux\\Mvp\\Backend\\'),
    Router::class => fn (ContainerInterface $container) => $container->get(AttributeRouterLoader::class)->load(),
    Dispatcher::class => fn (ContainerInterface $container) => new Dispatcher($container, $container->get(AttributeControllerLoader::class)->load()),
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
    LayoutRenderer::class => create()->constructor(
        get(Router::class),
        get(ResponseFactoryInterface::class),
        get(StreamFactoryInterface::class),
        get('assetsUrl'),
    ),
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
    ViewContextFactoryInterface::class => get(CustomViewContextFactory::class),
    View::class => create()->constructor(
        get(ResponseFactoryInterface::class),
        get(StreamFactoryInterface::class),
        get(RendererFactoryInterface::class),
        get(ViewContextFactoryInterface::class),
        get('templates'),
    ),
    MarkdownInterface::class => create(Markdown::class),
    SessionTokenInterface::class => create(CookieToken::class)->constructor('token'),
    SessionResolverInterface::class => create(SignedTokenResolver::class)->constructor(
        'secret',
        'sha256',
        get(SessionSerializerInterface::class)
    ),
    SessionSerializerInterface::class => create(UserSessionSerializer::class),
    SessionHandler::class => create()->constructor(
        get(SessionTokenInterface::class),
        get(SessionResolverInterface::class),
    ),
    Firewall::class => create()->constructor(get('accessmap')),
    QueryValidator::class => create()->constructor([
        get(SessionHandler::class),
        get(Firewall::class),
    ]),
];
