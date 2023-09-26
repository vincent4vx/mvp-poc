<?php

use Quatrevieux\Mvp\App\Article\ArticleRequest;
use Quatrevieux\Mvp\App\Search\SearchRequest;

/**
 * @var \Quatrevieux\Mvp\App\Search\SearchRenderer $renderer
 * @var \Quatrevieux\Mvp\App\Search\SearchResponse $this
 */

?>

<h2>Recherche</h2>

<form action="<?= $renderer->url(new SearchRequest()) ?>" method="get">
    <input type="text" name="query" value="<?= htmlentities($this->query ?? '') ?>" />

    <?php foreach ($this->tags as $tag): ?>
        <label>
            <input type="radio" name="tag" value="<?= htmlentities($tag) ?>" <?= $this->tagActive($tag) ? 'checked' : '' ?> />
            <?= htmlentities($tag) ?>
        </label>
    <?php endforeach; ?>

    <input type="submit" value="Rechercher" />
</form>

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
