<?php

use Quatrevieux\Mvp\App\Article\ArticleRequest;

/**
 * @var \Quatrevieux\Mvp\App\Home\HomeRenderer $renderer
 * @var \Quatrevieux\Mvp\App\Home\HomeResponse $this
 */

?>

<h2>Home</h2>

<?php foreach ($this->articles as $article): ?>
    <article class="post">
        <h3>
            <a href="<?= $renderer->url(ArticleRequest::create($article->id)); ?>">
                <?= htmlentities($article->title) ?>
            </a>
        </h3>
        <p><?= $renderer->content(mb_substr($article->content, 0, 200)) ?></p>
        <p class="date"><?= $renderer->date($article->createdAt) ?></p>
    </article>
<?php endforeach; ?>
