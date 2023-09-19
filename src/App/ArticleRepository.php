<?php

namespace Quatrevieux\Mvp\App;

use DateTimeImmutable;
use PDO;

class ArticleRepository
{
    public function __construct(
        private readonly PDO $pdo,
    ) {
    }

    public function findById(int $id): Article
    {
        $stmt = $this->pdo->prepare('SELECT * FROM article WHERE id = :id');
        $stmt->bindValue('id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $this->instantiate($stmt->fetch(PDO::FETCH_ASSOC));
    }

    public function findLastArticles(int $limit): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM article ORDER BY created_at DESC LIMIT :limit');
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $articles = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articles[] = $this->instantiate($row);
        }

        return $articles;
    }

    public function search(?string $query, ?string $tag)
    {
        $sql = 'SELECT * FROM article WHERE ';
        $arguments = [];
        $criteria = [];

        if ($query) {
            $criteria[] = 'title LIKE :query OR content LIKE :query';
            $arguments['query'] = "%$query%";
        }

        if ($tag) {
            $criteria[] = 'tags LIKE :tag';
            $arguments['tag'] = "%$tag%";
        }

        $sql .= implode(' AND ', $criteria);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($arguments);

        $articles = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articles[] = $this->instantiate($row);
        }

        return $articles;
    }

    public function allTags(): array
    {
        $stmt = $this->pdo->query('SELECT tags FROM article');
        $tags = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            foreach (explode(',', $row['tags']) as $tag) {
                $tag = trim($tag);
                $tag = strtolower($tag);

                if ($tag) {
                    $tags[$tag] = $tag;
                }
            }
        }

        return array_values($tags);
    }

    private function instantiate(array $row): Article
    {
        return new Article(
            id: $row['id'],
            title: $row['title'],
            content: $row['content'],
            createdAt: new DateTimeImmutable($row['created_at']),
            tags: array_map(trim(...), explode(',', $row['tags'])),
        );
    }
}
