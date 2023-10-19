<?php

namespace Quatrevieux\Mvp\Backend\Blog\Home;

use Quatrevieux\Mvp\Backend\Blog\ArticleRepository;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(HomeRequest::class)]
class HomeController implements ControllerInterface
{
    public function __construct(
        private readonly ArticleRepository $repository,
    ) {
    }

    /**
     * @param HomeRequest $request
     * @return HomeResponse
     */
    public function handle(object $request): HomeResponse
    {
        return new HomeResponse(
            new ArticleList($this->repository->findLastArticles(10)),
        );
    }
}
