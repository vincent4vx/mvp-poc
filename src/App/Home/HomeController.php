<?php

namespace Quatrevieux\Mvp\App\Home;

use Quatrevieux\Mvp\App\ArticleRepository;
use Quatrevieux\Mvp\Core\ControllerInterface;

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
            $this->repository->findLastArticles(10),
        );
    }
}
