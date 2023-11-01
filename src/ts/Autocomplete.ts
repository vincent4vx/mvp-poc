export class Autocomplete {
    #selected: number|null = null;
    #value: string|null = null;
    #abortController: AbortController;
    #timeout: NodeJS.Timeout|null = null;

    constructor(
        private readonly input: HTMLInputElement,
        private readonly results: HTMLElement,
    ) {
        this.#abortController = new AbortController();
    }

    public init(): void {
        this.input.addEventListener('input', this.onInput.bind(this));
        this.input.addEventListener('keydown', this.onKeyPress.bind(this));
        this.input.addEventListener('blur', this.close.bind(this));
        this.input.addEventListener('focus', this.onInput.bind(this));
        this.results.addEventListener('mousedown', this.onClick.bind(this));
    }

    public close(): void {
        this.results.classList.remove('open');
        this.results.innerHTML = '';
        this.#selected = null;
        this.#value = null;
    }

    public select(position?: number): void {
        const count = this.results.querySelectorAll('li').length;

        if (position === undefined || position < 0 || position >= count) {
            this.#selected = null;
            this.input.value = this.#value ?? '';
            return;
        }

        this.#selected = position;

        // @todo factorize
        this.results.querySelectorAll('li').forEach((element, position: number) => {
            if (position !== this.#selected) {
                element.classList.remove('selected');
            } else {
                element.classList.add('selected');
                this.input.value = (element.textContent ?? '').trim();
            }
        });
    }

    private onInput(): void {
        const value = this.input.value;

        if (!value) {
            this.close();
            return;
        }

        if (this.#timeout) {
            clearTimeout(this.#timeout);
        }

        this.#timeout = setTimeout(() => {
            this.#value = value;
            this.#query(value);
        }, 200);
    }

    private onKeyPress(event: KeyboardEvent): void {
        // @todo method to close the results
        if (event.key === 'Escape') {
            this.close();
            return;
        }

        if (event.key === 'ArrowDown') {
            event.preventDefault();

            this.select(this.#selected === null ? 0 : this.#selected + 1);
        }

        if (event.key === 'ArrowUp') {
            event.preventDefault();

            // @todo select last if null
            this.select(this.#selected === null ? 0 : this.#selected - 1);
        }
    }

    private onClick(event: MouseEvent): void {
        const target = event.target as HTMLElement;

        if (!target.matches('li')) {
            return;
        }

        this.input.value = (target.textContent ?? '').trim();
        this.close();
    }

    #query(input: string): void {
        this.#abortController.abort();
        this.#abortController = new AbortController();

        const target = this.results.dataset.autocompleteSrc;

        fetch(
            `${target}&query=${input}`,
            {
                signal: this.#abortController.signal,
            }
        )
            .then(response => response.text())
            .then(data => {
                this.#selected = null;

                this.results.innerHTML = data;
                this.results.classList.add('open');
                this.results.style.top = `${this.input.offsetTop + this.input.offsetHeight}px`;
                this.results.style.left = `${this.input.offsetLeft}px`;
            })
        ;
    }
}
