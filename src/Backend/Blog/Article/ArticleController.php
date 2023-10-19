<?php

namespace Quatrevieux\Mvp\Backend\Blog\Article;

use Quatrevieux\Mvp\Backend\Blog\ArticleRepository;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(ArticleRequest::class)]
final class ArticleController implements ControllerInterface
{
    public function __construct(
        private readonly ArticleRepository $repository,
    ) {
    }

    /**
     * @param ArticleRequest $request
     * @return ArticleResponse
     */
    public function handle(object $request): ArticleResponse
    {
        return new ArticleResponse(
            $this->repository->findById($request->id),
        );
    }
}
