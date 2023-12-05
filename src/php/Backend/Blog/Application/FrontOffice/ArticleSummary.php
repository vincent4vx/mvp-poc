<?php

namespace Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice;

use DateTimeImmutable;
use Quatrevieux\Mvp\Backend\Blog\Domain\Article;
use Quatrevieux\Mvp\Backend\Blog\Domain\ValueObject\ArticleContent;
use Quatrevieux\Mvp\Backend\Blog\Domain\ValueObject\ArticleId;
use Quatrevieux\Mvp\Backend\Blog\Domain\ValueObject\Title;

final class ArticleSummary
{
    public function __construct(
        public readonly ArticleId $id,
        public readonly Title $title,
        public readonly ArticleContent $summary,
        public readonly DateTimeImmutable $createdAt,
    ) {
    }

    public static function fromArticle(Article $article): self
    {
        return new self(
            $article->id,
            $article->title,
            $article->content->summary(),
            $article->createdAt,
        );
    }
}
