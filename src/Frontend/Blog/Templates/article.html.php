<?php
/**
 * @var \Quatrevieux\Mvp\Backend\Blog\Article\ArticleResponse $this
 * @var \Quatrevieux\Mvp\Frontend\Blog\ArticleRenderer $renderer
 * @var \Quatrevieux\Mvp\Frontend\CustomViewContext $context
 */

$context->title = 'My Blog - ' . $this->article->title->value;

?>

<h1><?= $this->article->title->html() ?></h1>

<div class="date"><?= $renderer->date($this->article->createdAt) ?></div>
<ul class="tags">
    <?php foreach ($this->article->tags as $tag): ?>
        <li>
            <a href="<?= htmlentities($renderer->url($tag->search())) ?>">
                <?= $tag->html() ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?= $renderer->content($this->article->content) ?>
