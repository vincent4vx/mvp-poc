<?php

namespace Quatrevieux\Mvp\Frontend;

use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\Security\Firewall;
use Quatrevieux\Mvp\Core\View\ContextAwareRendererInterface;
use Quatrevieux\Mvp\Core\View\Extensions\SecurityTrait;
use Quatrevieux\Mvp\Core\View\Renderer;
use Quatrevieux\Mvp\Core\View\RendererInterface;
use Quatrevieux\Mvp\Core\View\ViewContext;

class ApplicationRenderer extends Renderer implements ContextAwareRendererInterface
{
    use SecurityTrait;

    private ?ViewContext $context = null;

    public function __construct(
        private readonly Firewall $firewall,
        Router $router,
        string $template,
        ?RendererInterface $parent = null
    ) {
        parent::__construct($router, $template, $parent);
    }

    /**
     * {@inheritdoc}
     */
    public function withContext(ViewContext $context): static
    {
        $renderer = clone $this;
        $renderer->context = $context;

        return $renderer;
    }
}
