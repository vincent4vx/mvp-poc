<?php

namespace Quatrevieux\Mvp\Core\Module;

abstract class AbstractModule implements ModuleInterface
{
    private Module $built;

    public function __construct()
    {
        $builder = new ModuleBuilder();
        $this->build($builder);
        $this->built = $builder->build();
    }

    abstract protected function build(ModuleBuilder $builder): void;

    final public function routes(): array
    {
        return $this->built->routes();
    }

    final public function controllers(): array
    {
        return $this->built->controllers();
    }

    final public function renderers(): array
    {
        return $this->built->renderers();
    }

    final public function accessmap(): array
    {
        return $this->built->accessmap();
    }

    final public function definitions(): array
    {
        return $this->built->definitions();
    }

    public function handlers(): array
    {
        return $this->built->handlers();
    }

    public function withPrefix(string $prefix): static
    {
        $new = clone $this;
        $new->built = $this->built->withPrefix($prefix);

        return $new;
    }

    public function withDefaultAccess(callable|string $access): static
    {
        $new = clone $this;
        $new->built = $this->built->withDefaultAccess($access);

        return $new;
    }
}
