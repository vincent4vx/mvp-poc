<?php

namespace Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Article;

use Quatrevieux\Mvp\Core\Route;

#[Route('/article')]
final class ArticleRequest
{
    public int $id;

    public static function create(int $id): ArticleRequest
    {
        $request = new self();
        $request->id = $id;

        return $request;
    }
}
