<?php

use Michelf\Markdown;
use Michelf\MarkdownInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Quatrevieux\Mvp\Backend\BackOffice\Security\AdminAccessValidator;
use Quatrevieux\Mvp\Backend\Domain\Security\SessionRoleCheck;
use Quatrevieux\Mvp\Backend\Domain\Security\UserSessionSerializer;
use Quatrevieux\Mvp\Core\AttributeControllerLoader;
use Quatrevieux\Mvp\Core\AttributeRouterLoader;
use Quatrevieux\Mvp\Core\Bus\BusDispatcherInterface;
use Quatrevieux\Mvp\Core\Bus\CommandDispatcherLoader;
use Quatrevieux\Mvp\Core\CookieToken;
use Quatrevieux\Mvp\Core\Dispatcher;
use Quatrevieux\Mvp\Core\QueryValidator;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\Security\AuthenticatedAccess;
use Quatrevieux\Mvp\Core\Security\Firewall;
use Quatrevieux\Mvp\Core\Security\FirewallLoader;
use Quatrevieux\Mvp\Core\Security\SessionRoleCheckInterface;
use Quatrevieux\Mvp\Core\SessionHandler;
use Quatrevieux\Mvp\Core\SessionResolverInterface;
use Quatrevieux\Mvp\Core\SessionSerializerInterface;
use Quatrevieux\Mvp\Core\SessionTokenInterface;
use Quatrevieux\Mvp\Core\SignedTokenResolver;
use Quatrevieux\Mvp\Core\View\Renderer;
use Quatrevieux\Mvp\Core\View\RendererFactoryInterface;
use Quatrevieux\Mvp\Core\View\RendererInterface;
use Quatrevieux\Mvp\Core\View\View;
use Quatrevieux\Mvp\Core\View\ViewContextFactoryInterface;
use Quatrevieux\Mvp\Frontend\ApplicationRenderer;
use Quatrevieux\Mvp\Frontend\ApplicationViewContextFactory;
use Quatrevieux\Mvp\Frontend\BackOffice\BackOfficeLayoutRender;
use Quatrevieux\Mvp\Frontend\FrontOfficeLayoutRender;

use function DI\create;
use function DI\get;
use function DI\value;

return [
    'db' => require __DIR__ . '/db.php',
    'baseUrl' => value('http://127.0.0.1/micro-mvp'),
    'assetsUrl' => value('http://127.0.0.1/micro-mvp/assets'),
    'authenticated-user.pepper' => value('pepper-secret'),

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
    SessionTokenInterface::class => create(CookieToken::class)->constructor('token'),
    SessionResolverInterface::class => create(SignedTokenResolver::class)->constructor(
        'secret',
        'sha256',
        get(SessionSerializerInterface::class)
    ),
    SessionSerializerInterface::class => get(UserSessionSerializer::class),
    SessionHandler::class => create()->constructor(
        get(SessionTokenInterface::class),
        get(SessionResolverInterface::class),
    ),
    QueryValidator::class => create()->constructor([
        get(SessionHandler::class),
        get(Firewall::class),
        get(AdminAccessValidator::class),
    ]),
    AuthenticatedAccess::class => create()->constructor(
        get(SessionHandler::class),
        get(SessionRoleCheckInterface::class),
    ),
    SessionRoleCheckInterface::class => get(SessionRoleCheck::class),
];
