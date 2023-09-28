<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

use function is_string;

// @todo MVC view system ?
// Faire un système de renderer complètement indépendant du MVP de base, étant lui même MVC pour gérer le layout (pseudo front controller)
// ainsi que les composants, et chargement de l'user (ou autre)
class View
{
    private ?ViewContext $context = null;

    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly RendererFactoryInterface $rendererFactory,
        private readonly ViewContextFactoryInterface $viewContextFactory,

        /**
         * @var array<class-string, string>
         */
        private readonly array $templates = [],
    ) {
    }

    public function context(): ?ViewContext
    {
        return $this->context;
    }

    public function response(HandledQuery $query): ResponseInterface
    {
        $view = clone $this;
        $view->context = $this->viewContextFactory->createContext(
            $query->request,
            $query->query,
            $query->response,
        );

        $result = $query->response;

        // @todo ?
        if ($result instanceof ResponseInterface) {
            return $result;
        }

        $renderer = $view->resolveRenderer($result) ?? throw new \InvalidArgumentException('Renderer not found');
        $content = $renderer->render($view, $result);

        // @todo ?
        if ($content instanceof ResponseInterface) {
            return $content;
        }

        $view->context->content = $content;

        if ($layoutRenderer = $view->resolveRenderer($view->context)) {
            $content = $layoutRenderer->render($view, $view->context);

            if ($content instanceof ResponseInterface) {
                return $content;
            }
        }

        return $view->responseFactory->createResponse(200)
            ->withHeader('Content-Type', 'text/html')
            ->withBody($view->streamFactory->createStream($content))
        ;
    }

    public function renderResponse(object $response): string|ResponseInterface
    {
        $renderer = $this->resolveRenderer($response) ?? throw new \InvalidArgumentException('Renderer not found');

        return $renderer->render($this, $response);
    }

    public function renderComponent(ComponentInterface $component): string
    {
        if ($this->context) {
            $this->context->components[] = $component::class;
        }

        $renderer = $component->renderer();

        if (is_string($renderer)) {
            $renderer = $this->rendererFactory->forTemplate($renderer);
        }

        // @todo should get root element instead of wrapping it
        return '<div id="'.$component->id().'">' . $renderer->render($this, $component) . '</div>';
    }

    public function renderTemplate(string $template, object $context): string|ResponseInterface
    {
        $renderer = $this->rendererFactory->forTemplate($template);

        return $renderer->render($this, $context);
    }

    private function resolveRenderer(object $context): ?RendererInterface
    {
        $template = $this->templates[$context::class] ?? null;

        if ($template === null) {
            return null;
        }

        return $this->rendererFactory->forTemplate($template);
    }
}
