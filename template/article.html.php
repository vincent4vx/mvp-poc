<?php
/**
 * @var \Quatrevieux\Mvp\App\Article\ArticleResponse $this
 * @var \Quatrevieux\Mvp\App\Article\ArticleRenderer $renderer
 * @var \Quatrevieux\Mvp\App\CustomViewContext $context
 */

use Quatrevieux\Mvp\App\Search\SearchRequest;

$context->title = 'My Blog - ' . $this->article->title;

?>

<h2><?= htmlentities($this->article->title) ?></h2>

<div class="date"><?= $renderer->date($this->article->createdAt) ?><div>
<ul class="tags">
    <?php foreach ($this->article->tags as $tag): ?>
        <li>
            <a href="<?= htmlentities($renderer->url(SearchRequest::tag($tag))) ?>">
                <?= htmlentities($tag) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?= $renderer->content($this->article->content) ?>
