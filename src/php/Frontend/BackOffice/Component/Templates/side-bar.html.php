<?php
/**
 * @var \Quatrevieux\Mvp\Frontend\BackOffice\Component\BackOfficeSideBar $this
 * @var \Quatrevieux\Mvp\Core\View\Renderer $renderer
 * @var \Quatrevieux\Mvp\Frontend\BackOffice\BackOfficeViewContext $context
 */

?>

<?php if ($this->menu?->hasSubItems()): ?>
<nav>
    <ul>
        <?php foreach ($this->menu->subItems() as $request => $label): ?>
            <li class="<?= $context->query instanceof $request ? 'active' : '' ?>">
                <a href="<?= $renderer->url(new $request()) ?>"><?= $label ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<?php endif; ?>
