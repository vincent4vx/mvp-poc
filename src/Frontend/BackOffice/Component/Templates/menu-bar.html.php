<?php
/**
 * @var \Quatrevieux\Mvp\Frontend\BackOffice\Component\BackOfficeMenuBar $this
 * @var \Quatrevieux\Mvp\Core\View\Renderer $renderer
 * @var \Quatrevieux\Mvp\Frontend\BackOffice\BackOfficeViewContext $context
 */

use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Home\HomeRequest;

?>

<nav>
    <?php foreach ($this->menu ?? [] as $item): ?>
        <ul>
            <li class="<?= $item->active($context->query) ? 'active' : '' ?>">
                <a href="<?= $renderer->url($item->request) ?>"><?= $item->label ?></a>
            </li>
        </ul>
    <?php endforeach; ?>

</nav>
<a class="right no-pjax" href="<?= $renderer->url(new HomeRequest()); ?>">Back to site</a>
