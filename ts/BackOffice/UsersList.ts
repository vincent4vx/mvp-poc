import App from '../App';
import { Listener } from '../Dispatcher';
import { PJaxFinishEvent } from '../PJax';
import { AutoSearch } from '../AutoSearch';

export default class UsersList {
    #search: AutoSearch|null = null;

    constructor(
        private readonly app: App,
    ) {
    }

    start(): void {
        this.onLoadingPage();
    }

    @Listener(PJaxFinishEvent)
    onLoadingPage(): void {
        const form = this.app.dom.querySelector('#list-users-form') as HTMLFormElement|null;

        if (!form) {
            return;
        }

        this.#search = new AutoSearch(
            form,
            form.dataset.autosearchSource as string,
            this.app.dom.querySelector(form.dataset.autosearchTarget as string) as HTMLElement,
        );

        this.#search.init();
    }
}
