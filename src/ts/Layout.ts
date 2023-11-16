import { PJaxFinishEvent, PJaxLoadingEvent } from './PJax';
import { Listener } from './Dispatcher';
import { Autocomplete } from './Autocomplete';
import App from './App';

export class Layout {
    #searchAutocomplete: Autocomplete|null;

    constructor(
        private readonly dom: Document,
        private readonly app: App,
    ) {
        this.#searchAutocomplete = null;
    }

    start(): void {
        const input = this.dom.querySelector('#search-bar input[name=query]');
        const autocompleteResults = this.dom.querySelector('#search-bar .autocomplete-results');

        if (!input || !autocompleteResults) {
            return;
        }

        this.#searchAutocomplete = new Autocomplete(
            input as HTMLInputElement,
            autocompleteResults as HTMLElement,
        );
        this.#searchAutocomplete.init();
    }

    @Listener(PJaxLoadingEvent)
    onPjaxLoading(event: PJaxLoadingEvent): void {
        this.dom.querySelector('#page-content')?.classList?.add('loading');

        if (!event.trigger) {
            return;
        }

        // @todo handle layout change
        // @todo config elements / classes
        if (this.dom.querySelector('header')?.contains(event.trigger)) {
            this.dom.querySelector('#page-content')?.classList.add('loading-start-top');
        }
    }

    @Listener(PJaxFinishEvent)
    checkLayoutHasChanged(event: PJaxFinishEvent): void {
        const currentLayout = this.dom.querySelector('html')?.dataset.layout;

        console.log(currentLayout, event.content.layout);

        if (!currentLayout) {
            return;
        }

        if (currentLayout !== event.content.layout) {
            this.app.reload();
        }
    }

    @Listener(PJaxFinishEvent)
    onPjaxFinish(): void {
        const pageContentElement = this.dom.querySelector('#page-content');

        if (!pageContentElement) {
            return;
        }

        pageContentElement.classList.remove('loading');

        // @todo config elements / classes
        if (pageContentElement.classList.contains('loading-start-top')) {
            pageContentElement.classList.remove('loading-start-top');
            pageContentElement.classList.add('loading-end-top');
            setTimeout(function () {
                pageContentElement.classList.remove('loading-end-top');
            }, 300);
        }

        // @todo config elements / classes
        if (pageContentElement.classList.contains('loading-start-left')) {
            pageContentElement.classList.remove('loading-start-left');
            pageContentElement.classList.add('loading-end-left');
            setTimeout(function () {
                pageContentElement.classList.remove('loading-end-left');
            }, 300);
        }
    }
}
