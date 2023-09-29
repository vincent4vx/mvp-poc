<?php

use Quatrevieux\Mvp\App\Home\HomeRequest;
use Quatrevieux\Mvp\App\MenuBar;
use Quatrevieux\Mvp\App\Search\SearchRequest;
use Quatrevieux\Mvp\App\SearchBar;
use Quatrevieux\Mvp\App\User\AuthenticationForm\AuthenticationFormRequest;
use Quatrevieux\Mvp\Core\PageContent;

/**
 * @var \Quatrevieux\Mvp\Core\Renderer $renderer
 * @var \Quatrevieux\Mvp\Core\ViewContext|\Quatrevieux\Mvp\App\CustomViewContext $this
 * @var \Quatrevieux\Mvp\Core\View $view
 */

?>
<!DOCTYPE html>
<html lang="en">
    <!-- Google font pacifico -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlentities($this->title ?? 'My Blog') ?></title>
        <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" integrity="sha256-<?= base64_encode(hash_file('sha256', __DIR__.'/../public/assets/css/style.css', true)) ?>" />
    </head>
    <body>
        <header>
            <a class="logo" href="<?= $renderer->url(new HomeRequest()) ?>">My Blog</a>
            <?= $view->renderComponent(new SearchBar()) ?>
            <?= $view->renderComponent(new MenuBar($this->user)) ?>
        </header>
        <?= $view->renderComponent(new PageContent($this->content)) ?>
        <script>
            const layout = "<?= md5_file(__FILE__); ?>";

            // document.querySelector('header').addEventListener('click', function (e) {
            //     if (e.target.matches('a')) {
            //         document.querySelector('#page-content').classList.add('loading-start-top');
            //     }
            // });
            //
            // function onLoad() {
            //     if (document.querySelector('#page-content').classList.contains('loading-start-top')) {
            //         document.querySelector('#page-content').classList.remove('loading-start-top');
            //         document.querySelector('#page-content').classList.add('loading-end-top');
            //         setTimeout(function () {
            //             document.querySelector('#page-content').classList.remove('loading-end-top');
            //         }, 300);
            //     }
            //
            //     document.querySelectorAll('.post h3 a').forEach(function (e) {
            //         e.addEventListener('click', function (_) {
            //             window.scrollTo(0, 0);
            //
            //             let post = e.closest('.post');
            //
            //             post.style.position = 'fixed';
            //             post.style.height = post.offsetHeight + 'px';
            //             post.style.top = post.offsetTop + 'px';
            //
            //             setTimeout(function () {
            //                 post.classList.add('opening');
            //
            //                 post.style.height = null;
            //                 post.style.top = null;
            //             }, 1);
            //             //e.classList.add('animated');
            //         });
            //     });
            // }
            //
            // function handlePjaxResponse(response) {
            //     try {
            //         let content = JSON.parse(response);
            //
            //         // Layout changed, reload page
            //         if (content.layout !== layout) {
            //             location.reload();
            //             return;
            //         }
            //
            //         document.title = content.title || 'My Blog';
            //
            //         for (let id in content) {
            //             const e = document.getElementById(id);
            //
            //             if (e) {
            //                 const newElement = document.createElement('div');
            //                 newElement.innerHTML = content[id];
            //
            //                 e.replaceChildren(...newElement.children[0].childNodes);
            //             }
            //         }
            //
            //         onLoad();
            //     } catch (e) {
            //         document.open();
            //         document.write(response);
            //         document.close();
            //         location.reload();
            //     }
            // }
            //
            // function loadPjax(target, shouldPushState = true) {
            //     if (shouldPushState) {
            //         // change current url
            //         history.pushState(null, null, target);
            //     }
            //
            //     return fetch(target, {
            //         headers: {
            //             'X-PJAX': 'true',
            //         }
            //     })
            //     .then(function (response) {
            //         if (shouldPushState && response.url !== target) {
            //             history.pushState(null, null, response.url);
            //         }
            //
            //         return response.text();
            //     })
            //     .then(function (content) {
            //         handlePjaxResponse(content);
            //     });
            // }
            //
            // // pjax
            // document.addEventListener('click', function (e) {
            //     // @todo filter link if not pjax
            //     if (e.target.matches('a')) {
            //         e.preventDefault();
            //         loadPjax(e.target.href);
            //     }
            // });
            //
            // // pjax for form
            // document.addEventListener('submit', function (e) {
            //     if (e.target.matches('form')) {
            //         e.preventDefault();
            //
            //         // @todo remove once loaded
            //         e.target.classList.add('submitting');
            //         e.target.inert = true;
            //
            //         // change current url
            //         history.pushState(null, null, e.target.action);
            //
            //         let url = e.target.action;
            //
            //         if (e.target.method === 'get') {
            //             url += (url.includes('?') ? '&' : '?') + new URLSearchParams(new FormData(e.target));
            //             loadPjax(url).finally(function () {
            //                 e.target.classList.remove('submitting');
            //                 e.target.inert = false;
            //             });
            //             return;
            //         }
            //
            //         // @todo factorise post form
            //         let options = {
            //             method: e.target.method,
            //             headers: {
            //                 'X-PJAX': 'true',
            //             }
            //         };
            //
            //         if (e.target.method !== 'get') {
            //             options.body = new FormData(e.target);
            //         }
            //
            //         fetch(url, options)
            //         .then(function (response) {
            //             if (response.url !== e.target.action) {
            //                 history.pushState(null, null, response.url);
            //             }
            //
            //             return response.text();
            //         })
            //         .then(function (content) {
            //             handlePjaxResponse(content);
            //         });
            //     }
            // });
            //
            // // Handle back button, by try to perform a pjax request
            // window.addEventListener('popstate', function (e) {
            //     loadPjax(location.href, false);
            // });
            //
            // onLoad();
        </script>
        <script src="assets/js/main.js" async></script>
    </body>
</html>
