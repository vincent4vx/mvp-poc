import App from './App';
import { Event } from './Dispatcher';

export class PJaxLoadingEvent implements Event {
    readonly name = 'pjax:loading';

    constructor(
        public readonly target: string,
        public readonly trigger?: HTMLElement,
    ) {
    }
}

export class PJaxFinishEvent implements Event {
    readonly name = 'pjax:finish';

    constructor(
        public readonly target: string,
        public readonly content: Record<string, any>,
        public readonly trigger?: HTMLElement,
    ) {
    }
}

export interface PJaxConfig {
    defaultTitle: string;
    noPjaxSelector: string;
}

export default class PJax {
    constructor(
        private readonly app: App,
        private readonly config: PJaxConfig,
    ) {
    }

    public start() {
        this.#initAnchorClick();
        this.#initFormSubmit();
        this.#initHistoryNavigation();
    }

    /**
     * Perform a pjax request using GET method
     *
     * @param target Target URL
     * @param shouldPushState Should push the target URL to the history
     * @param trigger The element that triggered the request, if any. Can be an anchor or a form for example.
     */
    public load(target: string, shouldPushState: boolean = true, trigger?: HTMLElement): Promise<object|undefined> {
        return this.send(target, {}, shouldPushState, trigger);
    }

    /**
     * Perform a pjax request using POST method
     *
     * @param target Target URL
     * @param body Request body
     * @param shouldPushState Should push the target URL to the history
     * @param trigger The element that triggered the request, if any. Can be an anchor or a form for example.
     */
    public submit(target: string, body: BodyInit, shouldPushState: boolean = true, trigger?: HTMLElement): Promise<object|undefined> {
        return this.send(
            target,
            {
                method: 'post',
                body: body,
            },
            shouldPushState,
            trigger
        );
    }

    /**
     * Low level method to perform a pjax request
     *
     * @param target Target URL
     * @param init Fetch options
     * @param shouldPushState Should push the target URL to the history
     * @param trigger The element that triggered the request, if any. Can be an anchor or a form for example.
     */
    public send(target: string, init: RequestInit, shouldPushState: boolean = true, trigger?: HTMLElement): Promise<object|undefined> {
        this.app.dispatch(new PJaxLoadingEvent(target, trigger));

        if (shouldPushState) {
            // change current url
            history.pushState(null, '', target);
        }

        if (!init.headers) {
            init.headers = {'X-PJAX': 'true'};
        }

        return fetch(target, init)
            .then((response: Response) => {
                if (shouldPushState && response.url !== target) {
                    history.pushState(null, '', response.url);
                }

                return response.text();
            })
            .then((content: string) => this.#onResponse(content))
            .then((content: object|undefined) => {
                if (content) {
                    this.app.dispatch(new PJaxFinishEvent(target, content, trigger));
                }

                return content;
            })
        ;
    }

    #onResponse(response: string): object|undefined {
        try {
            let content = JSON.parse(response);
            const document = this.app.dom;

            // @todo config for default title
            document.title = content.title || this.config.defaultTitle;

            for (let id in content) {
                const e = document.getElementById(id);

                if (e) {
                    const newElement = document.createElement('div');
                    newElement.innerHTML = content[id];

                    e.replaceChildren(...newElement.children[0].childNodes);
                }
            }

            return content;
        } catch (e) {
            this.app.reload(response);
        }
    }

    #initAnchorClick() {
        this.app.dom.addEventListener('click', (e: MouseEvent): void => {
            const target = e.target as HTMLElement;

            if (target === null || target.matches(this.config.noPjaxSelector)) {
                return;
            }

            if (target instanceof HTMLAnchorElement && target.matches('a')) {
                e.preventDefault();
                this.load(target.href, true, target);
            }
        });
    }

    #initFormSubmit() {
        this.app.dom.addEventListener('submit', (e: SubmitEvent): void => {
            if (e.target instanceof HTMLFormElement && e.target.matches('form')) {
                e.preventDefault();

                const target: HTMLFormElement = e.target;

                target.classList.add('submitting');
                target.inert = true;

                let url = target.action;

                if (target.method === 'get') {
                    url += (url.includes('?') ? '&' : '?') + new URLSearchParams(new FormData(target) as any);
                    this.load(url).then(function () {
                        target.classList.remove('submitting');
                        target.inert = false;
                    });
                    return;
                }

                this.submit(url, new URLSearchParams(new FormData(target) as any)).then(() => {
                    target.classList.remove('submitting');
                    target.inert = false;
                });
            }
        });
    }

    #initHistoryNavigation() {
        window.addEventListener('popstate', (e: PopStateEvent) => {
            this.load(location.href, false);
        });
    }
}
