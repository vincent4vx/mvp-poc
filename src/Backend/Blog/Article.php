<?php

namespace Quatrevieux\Mvp\Backend\Blog;

use DateTimeImmutable;
use Quatrevieux\Mvp\Backend\Blog\ValueObject\ArticleContent;
use Quatrevieux\Mvp\Backend\Blog\ValueObject\ArticleId;
use Quatrevieux\Mvp\Backend\Blog\ValueObject\ArticleTags;
use Quatrevieux\Mvp\Backend\Blog\ValueObject\Title;

final class Article
{
    public function __construct(
        public readonly ArticleId $id,
        public readonly Title $title,
        public readonly ArticleContent $content,
        public readonly DateTimeImmutable $createdAt,
        public readonly ArticleTags $tags,
    ) {
    }
}
