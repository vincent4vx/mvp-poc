<?php

/**
 * @var \Quatrevieux\Mvp\Frontend\Blog\HomeRenderer $renderer
 * @var \Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Home\HomeResponse $this
 * @var \Quatrevieux\Mvp\Core\View\View $view
 */

?>

<h1>Home</h1>

<?= $view->renderResponse($this->articles) ?>
