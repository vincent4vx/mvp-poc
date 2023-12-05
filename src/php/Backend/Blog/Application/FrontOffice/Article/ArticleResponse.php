<?php

namespace Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Article;

use DateTimeImmutable;
use Quatrevieux\Mvp\Backend\Blog\Domain\ValueObject\ArticleContent;
use Quatrevieux\Mvp\Backend\Blog\Domain\ValueObject\ArticleTags;
use Quatrevieux\Mvp\Backend\Blog\Domain\ValueObject\Title;

final class ArticleResponse
{
    public function __construct(
        public readonly Title $title,
        public readonly ArticleContent $content,
        public readonly DateTimeImmutable $createdAt,
        public readonly ArticleTags $tags,
    ) {
    }
}
