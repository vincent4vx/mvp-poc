import App from './App';
import { Listener } from './Dispatcher';
import { PJaxFinishEvent, PJaxLoadingEvent } from './PJax';

export default class Chat {
    #source: string|null = null;
    #inChat: boolean = false;
    #timer: NodeJS.Timeout|null = null;
    #pullingDelay: number = 0;
    #autoScroll: boolean = true;
    #eventSource: EventSource|null = null;

    constructor(
        private readonly app: App,
    ) {
    }

    start(): void {
        this.onLoadingChat();
    }

    async refresh(): Promise<void> {
        // @todo selector as parameter
        const messages = this.app.dom.querySelector('#chat .messages') as HTMLElement|null;

        return fetch(this.#source ?? '')
            .then(response => response.text())
            .then(text => {
                if (messages !== null&& this.#inChat) {
                    messages.innerHTML = text;

                    if (this.#autoScroll) {
                        messages.scrollTo(0, messages.scrollHeight);
                    }
                }
            })
        ;
    }

    @Listener(PJaxLoadingEvent)
    onPageUnload() {
        this.#inChat = false;
        this.#source = null;
        this.#pullingDelay = 0;
        this.#autoScroll = true;

        if (this.#eventSource !== null) {
            this.#eventSource.close();
            this.#eventSource = null;
        }

        if (this.#timer !== null) {
            clearTimeout(this.#timer);
            this.#timer = null;
        }
    }

    // @todo detect if chat is open
    // @todo other event for page change ?

    @Listener(PJaxFinishEvent)
    onLoadingChat(): void {
        this.#inChat = false;
        const messages = this.app.dom.querySelector('#chat .messages') as HTMLElement|null;

        if (messages === null) {
            return;
        }

        messages.scrollTo(0, messages.scrollHeight);
        messages.addEventListener('scroll', () => {
            this.#autoScroll = messages.scrollTop + messages.clientHeight >= messages.scrollHeight;
        });

        this.#source = messages?.dataset.source ?? null;
        this.#pullingDelay = parseInt(messages?.dataset.pullingDelay ?? '0');

        if (!this.#source) {
            return;
        }

        this.#inChat = true;
        this.#focusInput();
        this.#startPulling();

        this.#eventSource = new EventSource(messages?.dataset.events ?? '');
        this.#eventSource.onmessage = (e) => {
            // @todo get only last messages
            this.refresh();
        };
        this.#eventSource.onerror = (ev) => {
            console.log('error', ev);
        };
    }

    #startPulling(): void {
        if (!this.#inChat || this.#pullingDelay <= 0) {
            return;
        }

        if (this.#timer !== null) {
            clearTimeout(this.#timer);
        }

        this.#timer = setTimeout(() => {
            this.refresh().then(() => {
                this.#startPulling();
            });
        }, this.#pullingDelay);
    }

    #focusInput(): void {
        const input = this.app.dom.querySelector('#chat [autofocus]') as HTMLInputElement|null;

        if (input !== null) {
            input.focus();
        }
    }
}
