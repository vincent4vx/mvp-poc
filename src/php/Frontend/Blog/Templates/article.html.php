<?php
/**
 * @var \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Article\ArticleResponse $this
 * @var \Quatrevieux\Mvp\Frontend\Blog\ArticleRenderer $renderer
 * @var \Quatrevieux\Mvp\Frontend\ApplicationViewContext $context
 */

$context->title = 'My Blog - ' . $this->title->value;

?>

<h1><?= $this->title->html() ?></h1>

<div class="date"><?= $renderer->date($this->createdAt) ?></div>
<ul class="tags">
    <?php foreach ($this->tags as $tag): ?>
        <li>
            <a href="<?= htmlentities($renderer->url($tag->search())) ?>">
                <?= $tag->html() ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?= $renderer->content($this->content) ?>
