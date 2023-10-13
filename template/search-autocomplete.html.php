<?php

use Quatrevieux\Mvp\App\Article\ArticleRequest;
use Quatrevieux\Mvp\App\Search\SearchRequest;

/**
 * @var \Quatrevieux\Mvp\App\Search\SearchRenderer $renderer
 * @var \Quatrevieux\Mvp\App\Search\SearchResponse $this
 * @var \Quatrevieux\Mvp\App\CustomViewContext $context
 */

$context->ajax = true;

?>

<ul>
    <?php foreach ($this->articles as $article): ?>
        <li>
            <?= htmlentities($article->title) ?>
<!--            <h3>-->
<!--                <a href="--><?php //= $renderer->url(ArticleRequest::create($article->id)); ?><!--">-->
<!--                </a>-->
<!--            </h3>-->
<!--            <p>--><?php //= $renderer->content(mb_substr($article->content, 0, 200)) ?><!--</p>-->
<!--            <p class="date">--><?php //= $renderer->date($article->createdAt) ?><!--</p>-->
        </li>
    <?php endforeach; ?>
</ul>
