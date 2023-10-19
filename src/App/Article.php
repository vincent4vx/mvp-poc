<?php

namespace Quatrevieux\Mvp\App;

use DateTimeImmutable;
use Quatrevieux\Mvp\App\ValueObject\ArticleContent;
use Quatrevieux\Mvp\App\ValueObject\ArticleId;
use Quatrevieux\Mvp\App\ValueObject\ArticleTags;
use Quatrevieux\Mvp\App\ValueObject\Title;

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
