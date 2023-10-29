export class AutoSearch {
    #abortController: AbortController;
    #timeout: NodeJS.Timeout|null = null;

    constructor(
        private readonly form: HTMLFormElement,
        private readonly source: string,
        private readonly results: HTMLElement,
    ) {
        this.#abortController = new AbortController();
    }

    public init(): void {
        this.form.addEventListener('input', this.onInput.bind(this));
    }

    private onInput(): void {
        if (this.#timeout) {
            clearTimeout(this.#timeout);
        }

        this.#timeout = setTimeout(() => {
            this.#query(new FormData(this.form));
        }, 200);
    }

    #query(data: FormData): void {
        this.#abortController.abort();
        this.#abortController = new AbortController();

        fetch(
            this.source + (this.source.indexOf('?') === -1 ? '?' : '&' ) + new URLSearchParams(data as any).toString(),
            {
                signal: this.#abortController.signal,
                method: 'GET',
            }
        )
            .then(response => response.text())
            .then(data => {
                this.results.innerHTML = data;
            })
        ;
    }
}
