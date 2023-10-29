<?php

namespace Quatrevieux\Mvp\Backend\Blog\Domain;

use DateTimeImmutable;
use Quatrevieux\Mvp\Backend\Blog\Domain\ValueObject\ArticleContent;
use Quatrevieux\Mvp\Backend\Blog\Domain\ValueObject\ArticleId;
use Quatrevieux\Mvp\Backend\Blog\Domain\ValueObject\ArticleTags;
use Quatrevieux\Mvp\Backend\Blog\Domain\ValueObject\Title;

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
