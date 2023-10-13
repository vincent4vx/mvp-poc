import { PJaxFinishEvent, PJaxLoadingEvent } from './PJax';
import { Listener } from './Dispatcher';

export class Post {
    constructor(
        private readonly dom: Document,
    ) {
    }

    @Listener(PJaxLoadingEvent)
    animateOpenPost(event: PJaxLoadingEvent): void {
        // @todo enable only on page with post ?
        if (!event.trigger) {
            return;
        }

        const postElement = event.trigger.closest('.post');

        if (!postElement || !(postElement instanceof HTMLElement)) {
            return;
        }

        window.scrollTo(0, 0);

        postElement.style.position = 'fixed';
        postElement.style.height = postElement.offsetHeight + 'px';
        postElement.style.top = postElement.offsetTop + 'px';

        setTimeout(function () {
            postElement.classList.add('opening');

            postElement.style.height = '';
            postElement.style.top = '';
        }, 1);
    }

    @Listener(PJaxLoadingEvent)
    animateTagClick(event: PJaxLoadingEvent): void {
        // @todo enable only on page with post ?
        if (!event.trigger) {
            return;
        }

        if (!event.trigger.closest('.tags')) {
            return;
        }

        this.dom.querySelector('#page-content')?.classList.add('loading-start-left');
    }
}
