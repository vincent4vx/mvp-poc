<?php

/**
 * @var \Quatrevieux\Mvp\Frontend\Blog\HomeRenderer $renderer
 * @var \Quatrevieux\Mvp\Backend\Blog\Home\HomeResponse $this
 * @var \Quatrevieux\Mvp\Core\View $view
 */

?>

<h1>Home</h1>

<?= $view->renderResponse($this->articles) ?>
