<?php

namespace Quatrevieux\Mvp\App\Article;

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
