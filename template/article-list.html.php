<?php

/**
 * @var \Quatrevieux\Mvp\App\Home\ArticleListRenderer $renderer
 * @var \Quatrevieux\Mvp\App\Home\ArticleList $this
 */

?>

<?php foreach ($this as $article): ?>
    <article class="post">
        <h3>
            <a href="<?= $renderer->url($article->id->toRequest()); ?>">
                <?= $article->title->html() ?>
            </a>
        </h3>
        <p><?= $renderer->content($article->content->summary()) ?></p>
        <p class="date"><?= $renderer->date($article->createdAt) ?></p>
    </article>
<?php endforeach; ?>
