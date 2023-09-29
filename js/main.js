//const layout = "<?= md5_file(__FILE__); ?>";

document.querySelector('header').addEventListener('click', function (e) {
    if (e.target.matches('a')) {
        document.querySelector('#page-content').classList.add('loading-start-top');
    }
});

function onLoad() {
    if (document.querySelector('#page-content').classList.contains('loading-start-top')) {
        document.querySelector('#page-content').classList.remove('loading-start-top');
        document.querySelector('#page-content').classList.add('loading-end-top');
        setTimeout(function () {
            document.querySelector('#page-content').classList.remove('loading-end-top');
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
                post.classList.add('opening');

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