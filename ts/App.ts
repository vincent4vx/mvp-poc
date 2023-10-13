import Dispatcher, { Event, EventSubscriber } from './Dispatcher';

export interface ServiceFactory<T> {
    useClass: new(...args: any[]) => T;
    factory: (app: App) => T;
    lazy?: boolean;
}

export type ServiceLoader = object|ServiceFactory<object>;
export type ServicesLoader = (app: App) => Array<ServiceLoader>;

export default class App {
    readonly #dispatcher: Dispatcher = new Dispatcher();
    readonly #services: Map<Function, ServiceLoader> = new Map();

    constructor(
        public readonly dom: Document,
        serviceLoader: ServicesLoader,
    ) {
        this.#loadServices(serviceLoader);
    }

    public start(): void {
        if (this.dom.readyState === 'loading') {
            this.dom.addEventListener('DOMContentLoaded', () => {
                this.#startServices();
            });
        } else {
            this.#startServices();
        }
    }

    public reload(content?: string): void {
        if (content) {
            this.dom.open();
            this.dom.write(content);
            this.dom.close();
        }

        location.reload();
    }

    public set(service: ServiceLoader) {
        const key = 'useClass' in service ? service.useClass : service.constructor;

        this.#services.set(key, service);
    }

    public get<T>(service: { new(...args: any[]): T }): T {
        const loader = this.#services.get(service);

        if (!loader) {
            throw new Error(`Service ${service.name} not found`);
        }

        if ('useClass' in loader && 'factory' in loader) {
            const instance = loader.factory(this);
            this.#services.set(service, instance);
            return instance as T;
        }

        return loader as T;
    }

    public dispatch(event: Event) {
        this.#dispatcher.dispatch(event);
    }

    #loadServices(serviceLoader: ServicesLoader): void {
        serviceLoader(this).forEach((service) => { this.set(service); });
    }

    #startServices() {
        this.#services.forEach((loader: ServiceLoader, key: Function) => {
            if ('lazy' in loader && loader.lazy) {
                return;
            }

            let instance = loader;

            if ('useClass' in loader && 'factory' in loader) {
                instance = loader.factory(this);
                this.#services.set(key, instance);
            }

            if ('start' in instance && typeof instance.start === 'function') {
                instance.start(this);
            }

            if ('listeners' in instance && typeof instance.listeners === 'function') {
                this.#dispatcher.register(instance as EventSubscriber);
            }
        });
    }
}
