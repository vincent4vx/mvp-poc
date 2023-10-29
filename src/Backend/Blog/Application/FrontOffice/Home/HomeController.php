<?php

namespace Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Home;

use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\ArticleList;
use Quatrevieux\Mvp\Backend\Blog\Domain\ArticleReadRepositoryInterface;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(HomeRequest::class)]
class HomeController implements ControllerInterface
{
    public function __construct(
        private readonly ArticleReadRepositoryInterface $repository,
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
