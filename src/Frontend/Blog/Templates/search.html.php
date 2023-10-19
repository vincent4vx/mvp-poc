<?php

use Quatrevieux\Mvp\Backend\Blog\Search\SearchRequest;

/**
 * @var \Quatrevieux\Mvp\Frontend\Blog\SearchRenderer $renderer
 * @var \Quatrevieux\Mvp\Backend\Blog\Search\SearchResponse $this
 * @var \Quatrevieux\Mvp\Core\View $view
 */

?>

<h1>Recherche</h1>

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

<?= $view->renderResponse($this->articles) ?>
