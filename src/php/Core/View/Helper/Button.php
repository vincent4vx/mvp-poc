<?php

namespace Quatrevieux\Mvp\Core\View\Helper;

use Quatrevieux\Mvp\Core\Router;
use Stringable;

use function htmlentities;
use function is_object;

class Button implements Stringable
{
    private object|string|null $target = null;
    private ?string $class = null;
    private bool $post = false;

    public function __construct(
        private readonly string $label,
        private readonly Router $router,
    ) {
    }

    public function target(object|string $target): static
    {
        $this->target = $target;

        return $this;
    }

    public function class(string $class): static
    {
        $this->class = $class;

        return $this;
    }

    public function post(object|string $target): static
    {
        $this->post = true;
        $this->target = $target;

        return $this;
    }

    public function __toString(): string
    {
        $target = $this->target;
        $class = $this->class;
        $label = $this->label;

        if ($this->post) {
            $data = '';

            if (is_object($target)) {
                foreach ((array)$target as $key => $value) {
                    if ($value !== null) {
                        $data .= sprintf('<input type="hidden" name="%s" value="%s" />', htmlentities($key), htmlentities($value));
                    }
                }

                $target = $target::class;
            }

            return sprintf(
                '<form action="%s" method="post" class="%s">%s<button type="submit">%s</button></form>',
                $this->router->generate($target),
                $class ? htmlentities($class) : '',
                $data,
                htmlentities($label)
            );
        }

        return sprintf(
            '<a href="%s" class="%s">%s</a>',
            $this->router->generate($target),
            $class ? htmlentities($class) : '',
            htmlentities($label)
        );
    }
}
