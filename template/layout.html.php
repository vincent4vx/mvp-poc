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
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
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
                padding: 5px;
                display: flex;
                z-index: 2;
                position: relative;
            }

            header > .logo {
                display: inline-block;
                margin: 0;
                flex: 1;
                font-family: Pacifico, sans-serif;
                font-size: 23px;
            }

            header > .logo a {
                display: inline-block;
                -webkit-text-stroke: 1px white;
                text-stroke: 1px white;
                font-weight: 800;
                letter-spacing: 2px;
                color: transparent;
                text-decoration: none;

                background-image:linear-gradient(#fff,#fff);
                background-size: 0 100%;
                background-position: left;
                background-repeat:no-repeat;
                transition: background-size 0.3s ease-in-out;
                -webkit-background-clip: text;
                background-clip: text;
            }

            header > .logo a:hover {
                background-size:100% 100%;
                transition: background-size 0.3s ease-in-out;
            }

            #search-bar {
                display: flex;
                align-self: center;
                margin-right: 15px;
            }

            #search-bar form {
                display: flex;
            }

            #search-bar form.submitting input {
                background-image: linear-gradient(90deg, #333, #555, #333);
                animation: loadingAnimation linear .3s infinite;
            }

            #search-bar input {
                display: block;
                padding: 5px;
                font-size: .8em;
                background: transparent;
                color: white;
                border-radius: 3px 0 0 3px;
                border: 1px solid #555;
                border-right: none;
                transition-property: background-color, border-color;
                transition-duration: .1s;
            }

            #search-bar input:focus {
                border: 1px solid #44a;
                border-right: none;
                outline: none;
                background: rgba(255, 255, 255, 0.1);
            }

            #search-bar input:focus + button {
                border: 1px solid #44a;
                border-left: none;
                background: rgba(255, 255, 255, 0.1);
                outline: none;
            }

            #search-bar button {
                display: block;
                padding: 5px;
                font-size: .8em;
                background: transparent;
                color: white;
                border-radius: 0 3px 3px 0;
                border: 1px solid #555;
                border-left: none;
                cursor: pointer;
                transition-property: background-color, border-color;
                transition-duration: .1s;
            }

            #menu-bar {
                margin-left: auto;
                display: flex;
            }

            #menu-bar nav {
                align-self: center;
            }

            header nav > ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            header nav > ul > li {
                display: inline-block;
                color: white;
            }

            header nav > ul > li > a {
                color: inherit;
                text-decoration: none;
                height: 100%;
                display: inline-block;
                padding: 3px;
                position: relative;
            }

            header nav > ul > li > a:hover::after {
                left: 0;
                width: 100%;
                transition: width 0.3s ease-in-out;
            }

            header nav > ul > li > a::after {
                content: " ";
                position: absolute;
                bottom: 0;
                left: 100%;
                width: 0;
                border-bottom: 1px solid white;
                transition: width 0.3s ease-in-out, left 0.3s ease-in-out;
                overflow: hidden;
            }

            #page-content {
                max-width: 50vw;
                margin: 0 auto;
                padding: 20px;
                position: relative;
            }

            #page-content.animated {
                overflow: hidden;
                max-height: 90vh;
                box-sizing: border-box;
                transform: translateY(100vh) scale(0.7);
                transition: transform .3s;
            }

            #page-content.open {
                overflow: hidden;
                max-height: 90vh;
                box-sizing: border-box;
                animation: open linear .3s;
            }

            @keyframes open {
                from {
                    transform: translateY(-100%) scale(0.7);
                }

                to {
                    transform: translateY(0) scale(1);
                }
            }

            .post {
                background-color: #fff;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            }

            @keyframes gradientAnimation {
                from {
                    background-size: 100% 100%;
                }

                to {
                    background-size: 400% 400%;
                }
            }

            .post.animated {
                background: #f4f4f4;
                height: calc(100vh - 50px);
                box-shadow: none;
                transition-property: height, margin-left, top, background-color;
                transition-duration: .3s;
                width: 50vw;
                margin-left: -25px;
                top: 50px;
                z-index: 2;
                position: fixed;
                background: radial-gradient(#f4f4f4, #fff);
                background-size: 100% 100%;
                animation: gradientAnimation linear .3s infinite;
                background-position: 50% 50%;
            }

            .post.animated h3, .post.animated h3 a {
                font-size: 24px;
                color: #333333;
                font-weight: 700;
                text-decoration: none;
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

            p.error {
                color: darkred;
                background-color: #ffdddd;
                border: 1px solid darkred;
                border-radius: 3px;
                margin: 5px;
                box-sizing: border-box;
                width: 100%;
                padding: 7px 15px;
            }

            #authentication-form input {
                box-sizing: border-box;
                margin: 5px;
                display: block;
                width: 100%;
                background-color: #fff;
                padding: 4px 8px;
                font-size: 1em;
                border-radius: 3px;
                border: 1px solid #ccc;
                transition-property: border-color, outline-width;
                transition-duration: .1s;
            }

            #authentication-form input:focus {
                border: 1px solid #bbf;
                outline: 1px solid #bbf;
            }

            #authentication-form input[type="submit"] {
                background-color: #68f;
                border: 1px solid #57d;
                text-shadow: 1px 1px 0 #333;
                color: #fff;
                cursor: pointer;
                transition-property: background-color, border-color;
                transition-duration: .1s;
            }

            #authentication-form input[type="submit"]:hover {
                background-color: #79f;
                border: 1px solid #68f;
            }

            #authentication-form input[type="submit"]:focus {
                background-color: #57d;
                border: 1px solid #46c;
                animation: btnColor linear .1s;
                background-size: 100% 100%;
                background-position: 50% 50%;
            }

            @keyframes btnColor {
                from {
                    background-image: radial-gradient(#57d, #79f);
                    background-size: 100% 100%;
                }

                to {
                    background-image: radial-gradient(#57d, #79f);
                    background-size: 300% 300%;
                }
            }

            #authentication-form.submitting input[type="submit"] {
                color: rgba(255, 255, 255, 0.5);
                text-shadow: none;
                background-image: linear-gradient(90deg, #57d, #79f, #57d);
                background-repeat: repeat;
                background-size: 120px 100%;
                animation: loadingAnimation linear .3s infinite;
            }

            @keyframes loadingAnimation {
                from {
                    background-position: 0 0;
                }

                to {
                    background-position: 120px 0;
                }
            }

            form.submitting input, form.submitting button {
                cursor: wait !important;
            }

            @media screen and (max-width: 1200px) {
                #page-content {
                    max-width: 100vw;
                }

                .post.animated {
                    width: 100vw;
                }
            }
        </style>
    </head>
    <body>
        <header>
            <h1 class="logo"><a href="<?= $renderer->url(new HomeRequest()) ?>">My Blog</a></h1>
            <?= $view->renderComponent(new SearchBar()) ?>
            <?= $view->renderComponent(new MenuBar($this->user)) ?>
        </header>
        <?= $view->renderComponent(new PageContent($this->content)) ?>
        <script>
            const layout = "<?= md5_file(__FILE__); ?>";

            document.querySelector('header').addEventListener('click', function (e) {
                if (e.target.matches('a')) {
                    document.querySelector('#page-content').classList.add('animated');
                }
            });

            function onLoad() {
                if (document.querySelector('#page-content').classList.contains('animated')) {
                    document.querySelector('#page-content').classList.remove('animated');
                    document.querySelector('#page-content').classList.add('open');
                    setTimeout(function () {
                        document.querySelector('#page-content').classList.remove('open');
                    }, 300);
                }

                document.querySelectorAll('.post h3 a').forEach(function (e) {
                    e.addEventListener('click', function (_) {
                        window.scrollTo(0, 0);

                        let post = e.closest('.post');

                        post.style.position = 'fixed';
                        post.style.height = post.offsetHeight + 'px';
                        post.style.top = post.offsetTop + 'px';

                        setTimeout(function () {
                            post.classList.add('animated');

                            post.style.height = null;
                            post.style.top = null;
                        }, 1);
                        //e.classList.add('animated');
                    });
                });
            }

            function handlePjaxResponse(response) {
                try {
                    let content = JSON.parse(response);

                    // Layout changed, reload page
                    if (content.layout !== layout) {
                        location.reload();
                        return;
                    }

                    document.title = content.title || 'My Blog';

                    for (let id in content) {
                        const e = document.getElementById(id);

                        if (e) {
                            const newElement = document.createElement('div');
                            newElement.innerHTML = content[id];

                            e.replaceChildren(...newElement.children[0].childNodes);
                        }
                    }

                    onLoad();
                } catch (e) {
                    document.open();
                    document.write(response);
                    document.close();
                    location.reload();
                }
            }

            function loadPjax(target, shouldPushState = true) {
                if (shouldPushState) {
                    // change current url
                    history.pushState(null, null, target);
                }

                return fetch(target, {
                    headers: {
                        'X-PJAX': 'true',
                    }
                })
                .then(function (response) {
                    if (shouldPushState && response.url !== target) {
                        history.pushState(null, null, response.url);
                    }

                    return response.text();
                })
                .then(function (content) {
                    handlePjaxResponse(content);
                });
            }

            // pjax
            document.addEventListener('click', function (e) {
                // @todo filter link if not pjax
                if (e.target.matches('a')) {
                    e.preventDefault();
                    loadPjax(e.target.href);
                }
            });

            // pjax for form
            document.addEventListener('submit', function (e) {
                if (e.target.matches('form')) {
                    e.preventDefault();

                    // @todo remove once loaded
                    e.target.classList.add('submitting');
                    e.target.inert = true;

                    // change current url
                    history.pushState(null, null, e.target.action);

                    let url = e.target.action;

                    if (e.target.method === 'get') {
                        url += (url.includes('?') ? '&' : '?') + new URLSearchParams(new FormData(e.target));
                        loadPjax(url).finally(function () {
                            e.target.classList.remove('submitting');
                            e.target.inert = false;
                        });
                        return;
                    }

                    // @todo factorise post form
                    let options = {
                        method: e.target.method,
                        headers: {
                            'X-PJAX': 'true',
                        }
                    };

                    if (e.target.method !== 'get') {
                        options.body = new FormData(e.target);
                    }

                    fetch(url, options)
                    .then(function (response) {
                        if (response.url !== e.target.action) {
                            history.pushState(null, null, response.url);
                        }

                        return response.text();
                    })
                    .then(function (content) {
                        handlePjaxResponse(content);
                    });
                }
            });

            // Handle back button, by try to perform a pjax request
            window.addEventListener('popstate', function (e) {
                loadPjax(location.href, false);
            });

            onLoad();
        </script>
    </body>
</html>
