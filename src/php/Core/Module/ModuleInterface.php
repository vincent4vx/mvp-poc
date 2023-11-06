<?php

namespace Quatrevieux\Mvp\Core\Module;

use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Security\QueryAccessValidatorInterface;
use Quatrevieux\Mvp\Core\View\RendererInterface;

interface ModuleInterface
{
    /**
     * @return array<string, class-string>
     */
    public function routes(): array;

    /**
     * @return array<class-string, ControllerInterface>
     * @psalm-return class-string-map<T, ControllerInterface<T>>
     */
    public function controllers(): array;

    /**
     * @return array<class-string, RendererInterface>
     */
    public function renderers(): array;

    /**
     * @return array<class-string, callable(object, ServerRequestInterface):bool|class-string<QueryAccessValidatorInterface>>
     */
    public function accessmap(): array;

    public function definitions(): array;

    public function handlers(): array;

    public function withPrefix(string $prefix): static;

    /**
     * @param callable(object, ServerRequestInterface):bool|class-string<QueryAccessValidatorInterface> $access
     * @return static
     */
    public function withDefaultAccess(callable|string $access): static;
}
