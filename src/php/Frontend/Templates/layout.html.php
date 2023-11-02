<?php

use Quatrevieux\Mvp\Backend\Blog\Application\FrontOffice\Home\HomeRequest;
use Quatrevieux\Mvp\Core\PageContent;
use Quatrevieux\Mvp\Frontend\Component\MenuBar;
use Quatrevieux\Mvp\Frontend\Component\SearchBar;

/**
 * @var \Quatrevieux\Mvp\Frontend\LayoutRenderer $renderer
 * @var \Quatrevieux\Mvp\Core\View\ViewContext|\Quatrevieux\Mvp\Frontend\ApplicationViewContext $this
 * @var \Quatrevieux\Mvp\Core\View\View $view
 */

?>
<!DOCTYPE html>
<html lang="en" data-layout="<?= md5_file(__FILE__); ?>">
    <!-- Google font pacifico -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlentities($this->title ?? 'My Blog') ?></title>
        <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet" />
        <?= $renderer->css('css/style.css') ?>
        <link rel="icon" type="image/png" href="http://127.0.0.1/micro-mvp/assets/images/favicon.ico" />
    </head>
    <body>
        <header>
            <a class="logo" href="<?= $renderer->url(new HomeRequest()) ?>">My Blog</a>
            <?= $view->renderComponent(new SearchBar()) ?>
            <?= $view->renderComponent(new MenuBar($this->user)) ?>
        </header>
        <?= $view->renderComponent(new PageContent($this->content)) ?>
        <script src="http://127.0.0.1/micro-mvp/assets/js/main.js" async></script>
    </body>
</html>
