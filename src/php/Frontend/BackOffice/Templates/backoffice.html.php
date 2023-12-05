<?php

use Quatrevieux\Mvp\Backend\BackOffice\Home\HomeRequest;
use Quatrevieux\Mvp\Core\PageContent;
use Quatrevieux\Mvp\Frontend\BackOffice\Component\BackOfficeMenuBar;
use Quatrevieux\Mvp\Frontend\BackOffice\Component\BackOfficeSideBar;

/**
 * @var \Quatrevieux\Mvp\Frontend\BackOffice\BackOfficeLayoutRender $renderer
 * @var \Quatrevieux\Mvp\Frontend\BackOffice\BackOfficeViewContext $this
 * @var \Quatrevieux\Mvp\Core\View\View $view
 */

?>
<!DOCTYPE html>
<html lang="en" data-layout="<?= md5_file(__FILE__); ?>">
    <!-- Google font pacifico -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlentities($this->title ?? 'BackOffice') ?></title>
        <?= $renderer->css('css/backoffice.css') ?>
        <link rel="icon" type="image/png" href="http://127.0.0.1/micro-mvp/assets/images/favicon.ico" />
    </head>
    <body>
        <header>
            <a class="logo" href="<?= $renderer->url(new HomeRequest()) ?>">Back office</a>
            <?= $view->renderComponent(new BackOfficeMenuBar($this->user)) ?>
        </header>
        <div id="middle">
            <?= $view->renderComponent(new BackOfficeSideBar()) ?>
            <?= $view->renderComponent(new PageContent($this->content)) ?>
        </div>
        <script src="<?= $renderer->asset('js/main.js') ?>" async></script>
    </body>
</html>
