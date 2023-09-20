<?php

use Quatrevieux\Mvp\App\Home\HomeRequest;
use Quatrevieux\Mvp\App\MenuBar;
use Quatrevieux\Mvp\App\User\AuthenticationForm\AuthenticationFormRequest;

/**
 * @var \Quatrevieux\Mvp\Core\Renderer $renderer
 * @var \Quatrevieux\Mvp\Core\ViewContext|\Quatrevieux\Mvp\App\CustomViewContext $this
 * @var \Quatrevieux\Mvp\Core\View $view
 */

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlentities($this->title ?? 'My Blog') ?></title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }

            header {
                background-color: #333;
                color: #fff;
                padding: 20px;
            }

            header > .logo {
                display: inline-block;
            }

            #menu-bar {
                float: right;
            }

            header nav > ul {
                list-style: none;
                padding: 0;
            }

            header nav > ul > li {
                float: left;
            }

            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
            }

            .post {
                background-color: #fff;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            }

            .post h2 {
                color: #333;
            }

            .post p {
                line-height: 1.6;
            }

            .post .date {
                color: #888;
                font-size: 0.8em;
            }

            .sidebar {
                background-color: #f4f4f4;
                padding: 20px;
            }

            .sidebar h3 {
                color: #333;
            }

            .sidebar ul {
                list-style: none;
                padding: 0;
            }

            .sidebar li {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <header>
            <h1 class="logo"><a href="<?= $renderer->url(new HomeRequest()) ?>">My Blog</a></h1>
            <div id="menu-bar">
                <?= $view->renderResponse(new MenuBar($this->user)) ?>
            </div>
        </header>
        <div class="container" id="main">
            <?= $this->content ?>
        </div>
        <script>
            // pjax
            document.addEventListener('click', function (e) {
                // @todo filter link if not pjax
                if (e.target.matches('a')) {
                    e.preventDefault();

                    // change current url
                    history.pushState(null, null, e.target.href);

                    fetch(e.target.href, {
                        headers: {
                            'X-PJAX': 'true'
                        }
                    })
                    .then(function (response) {
                        if (response.url !== e.target.href) {
                            history.pushState(null, null, response.url);
                        }

                        return response.text();
                    })
                    .then(function (content) {
                        try {
                            content = JSON.parse(content);
                            document.getElementById('main').innerHTML = content.content;
                            document.getElementById('menu-bar').innerHTML = content.menuBar;
                            document.title = content.title || 'My Blog';
                        } catch (e) {
                            document.open();
                            document.write(content);
                            document.close();
                            location.reload();
                        }
                    });
                }
            });

            // pjax for form
            document.addEventListener('submit', function (e) {
                if (e.target.matches('form')) {
                    e.preventDefault();

                    // change current url
                    history.pushState(null, null, e.target.action);

                    fetch(e.target.action, {
                        method: e.target.method,
                        body: new FormData(e.target),
                        headers: {
                            'X-PJAX': 'true'
                        }
                    })
                    .then(function (response) {
                        if (response.url !== e.target.action) {
                            history.pushState(null, null, response.url);
                        }

                        return response.text();
                    })
                    .then(function (content) {
                        try {
                            content = JSON.parse(content);
                            document.getElementById('main').innerHTML = content.content;
                            document.getElementById('menu-bar').innerHTML = content.menuBar;
                            document.title = content.title || 'My Blog';
                        } catch (e) {
                            document.open();
                            document.write(content);
                            document.close();
                            location.reload();
                        }
                    });
                }
            });

            // Handle back button, by try to perform a pjax request
            window.addEventListener('popstate', function (e) {
                fetch(location.href, {
                    method: 'GET',
                    headers: {
                        'X-PJAX': 'true'
                    }
                })
                .then(function (response) {
                    return response.text();
                })
                .then(function (content) {
                    try {
                        content = JSON.parse(content);
                        document.getElementById('main').innerHTML = content.content;
                        document.getElementById('menu-bar').innerHTML = content.menuBar;
                        document.title = content.title || 'My Blog';
                    } catch (e) {
                        document.open();
                        document.write(content);
                        document.close();
                        location.reload();
                    }
                });
            });
        </script>
    </body>
</html>
