<?php

namespace Quatrevieux\Mvp\Core\Module;

use DI\ContainerBuilder;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Quatrevieux\Mvp\Core\Bus\BusDispatcherInterface;
use Quatrevieux\Mvp\Core\Bus\CommandDispatcherLoader;
use Quatrevieux\Mvp\Core\Dispatcher;
use Quatrevieux\Mvp\Core\Router;

use Quatrevieux\Mvp\Core\Runner;
use Quatrevieux\Mvp\Core\Security\Firewall;
use Quatrevieux\Mvp\Core\Security\FirewallLoader;
use Quatrevieux\Mvp\Core\View\RendererFactoryInterface;

use Quatrevieux\Mvp\Core\View\View;
use Quatrevieux\Mvp\Core\View\ViewContextFactoryInterface;

use function DI\add;
use function DI\create;
use function DI\get;
use function DI\value;

class Application
{
    public readonly ContainerInterface $container;

    public function __construct(
        array $definitions,
        ModuleInterface ...$modules
    ) {
        $this->container = $this->configure($definitions, $modules);
    }

    public function runner(): Runner
    {
        return $this->container->get(Runner::class);
    }

    /**
     * @param list<ModuleInterface> $modules
     * @return ContainerInterface
     */
    private function configure(array $definitions, array $modules): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions(...$definitions);

        $containerBuilder->addDefinitions([
            'routes' => [],
            'controllers' => [],
            'renderers' => [],
            'accessmap' => [],
            'handlers' => [],

            Router::class => fn (ContainerInterface $container) => new Router($container->get('routes'), $container->get('baseUrl')),
            Dispatcher::class => fn (ContainerInterface $container) => new Dispatcher($container, $container->get('controllers')),
            Firewall::class => fn (ContainerInterface $container) => (new FirewallLoader($container))->load($container->get('accessmap')),
            BusDispatcherInterface::class => function (ContainerInterface $container) {
                return (new CommandDispatcherLoader($container))->load($container->get('handlers'));
            },
            View::class => create()->constructor(
                get(ResponseFactoryInterface::class),
                get(StreamFactoryInterface::class),
                get(RendererFactoryInterface::class),
                get(ViewContextFactoryInterface::class),
                get('renderers'),
            ),
        ]);

        foreach ($modules as $module) {
            $containerBuilder->addDefinitions([
                'routes' => add($module->routes()),
                'controllers' => add($module->controllers()),
                'renderers' => add($module->renderers()),
                'accessmap' => add($module->accessmap()),
                'handlers' => add($module->handlers()),
                ...$module->definitions(),
            ]);
        }

        return $containerBuilder->build();
    }
}
