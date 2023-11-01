<?php

namespace Quatrevieux\Mvp\Backend\Blog\Domain;

interface ArticleReadRepositoryInterface
{
    public function findById(int $id): Article;

    /**
     * @return array<\Quatrevieux\Mvp\Backend\Blog\Domain\Article>
     */
    public function findLastArticles(int $limit): array;

    /**
     * @param string|null $query
     * @param string|null $tag
     * @return array<\Quatrevieux\Mvp\Backend\Blog\Domain\Article>
     */
    public function search(?string $query, ?string $tag): array;

    /**
     * @return list<string>
     */
    public function allTags(): array;
}
