<?php

namespace Quatrevieux\Mvp\Frontend\Blog;

use Michelf\MarkdownInterface;
use Quatrevieux\Mvp\Backend\Blog\Domain\ValueObject\ArticleContent;
use Quatrevieux\Mvp\Core\Router;
use Quatrevieux\Mvp\Core\View\Renderer;

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

    public function content(ArticleContent $content): string
    {
        // Maybe cache on ValueObject ?
        return self::$markdownCache[md5($content->value)] ??= $content->html($this->markdown);
        //return $this->markdown->transform(htmlentities($content));
    }
}
