<?php

use Quatrevieux\Mvp\App\Article\ArticleRequest;

/**
 * @var \Quatrevieux\Mvp\App\Home\HomeRenderer $renderer
 * @var \Quatrevieux\Mvp\App\Home\HomeResponse $this
 * @var \Quatrevieux\Mvp\Core\View $view
 */

?>

<h1>Home</h1>

<?= $view->renderResponse($this->articles) ?>
