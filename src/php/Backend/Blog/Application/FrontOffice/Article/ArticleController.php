<?php

namespace Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Article;

use Quatrevieux\Mvp\Backend\Blog\Domain\ArticleReadRepositoryInterface;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(ArticleRequest::class)]
final class ArticleController implements ControllerInterface
{
    public function __construct(
        private readonly ArticleReadRepositoryInterface $repository,
    ) {
    }

    /**
     * @param ArticleRequest $request
     * @return ArticleResponse
     */
    public function handle(object $request): ArticleResponse
    {
        $article = $this->repository->findById($request->id);

        return new ArticleResponse(
            $article->title,
            $article->content,
            $article->createdAt,
            $article->tags,
        );
    }
}
