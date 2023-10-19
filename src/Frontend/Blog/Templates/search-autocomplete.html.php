<?php

/**
 * @var \Quatrevieux\Mvp\Frontend\Blog\SearchRenderer $renderer
 * @var \Quatrevieux\Mvp\Backend\Blog\Search\SearchResponse $this
 * @var \Quatrevieux\Mvp\Frontend\CustomViewContext $context
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
