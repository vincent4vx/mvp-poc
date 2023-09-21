<?php

namespace Quatrevieux\Mvp\App;

use Michelf\Markdown;
use Michelf\MarkdownInterface;
use Quatrevieux\Mvp\Core\Renderer;
use Quatrevieux\Mvp\Core\Router;

abstract class AbstractArticleRenderer extends Renderer
{
    // @todo not static !
    private static array $markdownCache = [];

    public function __construct(
        Router $router,
        private readonly MarkdownInterface $markdown,
    )
    {
        parent::__construct($router, static::template());
    }

    abstract static protected function template(): string;

    public function date(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d');
    }

    public function content(string $content): string
    {
        return self::$markdownCache[md5($content)] ??= $this->markdown->transform(htmlentities($content));
        //return $this->markdown->transform(htmlentities($content));
    }
}
