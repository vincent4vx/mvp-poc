import { PJaxFinishEvent, PJaxLoadingEvent } from './PJax';
import { Listener } from './Dispatcher';
import { Autocomplete } from './Autocomplete';

export class Layout {
    #searchAutocomplete: Autocomplete;

    constructor(
        private readonly dom: Document,
    ) {
        this.#searchAutocomplete = new Autocomplete(
            this.dom.querySelector('#search-bar input[name=query]') as HTMLInputElement,
            this.dom.querySelector('#search-bar .autocomplete-results') as HTMLElement,
        );
    }

    start(): void {
        this.#searchAutocomplete.init();
    }

    @Listener(PJaxLoadingEvent)
    onPjaxLoading(event: PJaxLoadingEvent): void {
        if (!event.trigger) {
            return;
        }

        // @todo config elements / classes
        if (this.dom.querySelector('header')?.contains(event.trigger)) {
            this.dom.querySelector('#page-content')?.classList.add('loading-start-top');
        }
    }

    @Listener(PJaxFinishEvent)
    onPjaxFinish(): void {
        const pageContentElement = this.dom.querySelector('#page-content');

        if (!pageContentElement) {
            return;
        }

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
