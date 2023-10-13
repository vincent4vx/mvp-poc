export interface Event {
    readonly name: string;
}

export interface EventSubscriber {
    listeners: () => Record<string, (Array<(event: Event) => void>)|((event: Event) => void)>;
}

const internalListeners = Symbol('internalListeners');

/**
 * Decorator to register a listener for an event
 *
 * @param event The event name or class
 */
export function Listener(event: string|(new (...args: any[]) => Event)) {
    return function (target: any, propertyKey: string, descriptor: PropertyDescriptor) {
        if (!(internalListeners in target)) {
            if ('listeners' in target) {
                throw new Error(`Cannot mix @Listener and 'listeners()' method on ${target.constructor.name}`);
            }

            target[internalListeners] = {};
            target.listeners = function () {
                const staticEvents: Record<string, Array<Function>> = this[internalListeners];
                const instanceEvents: Record<string, Array<Function>> = {};

                for (const [name, listeners] of Object.entries(staticEvents)) {
                    instanceEvents[name] = listeners.map((listener) => listener.bind(this));
                }

                return instanceEvents;
            };
        }

        let eventName = null;

        if (typeof event === 'string') {
            eventName = event;
        } else {
            eventName = new event().name;
        }

        if (!eventName) {
            throw new Error(`Cannot resolve the event name for ${target.constructor.name}.${propertyKey}`);
        }

        target[internalListeners][eventName] = target[internalListeners][eventName] ?? [];
        target[internalListeners][eventName].push(descriptor.value);
    };
}

export default class Dispatcher {
    private listeners: Record<string, Array<(event: Event) => void>> = {};

    public register(subscriber: EventSubscriber): void {
        for (const [name, listener] of Object.entries(subscriber.listeners())) {
            if (listener instanceof Array) {
                listener.forEach((listener) => { this.subscribe(name, listener) });
            } else {
                this.subscribe(name, listener);
            }
        }
    }

    public subscribe(name: string, listener: (event: Event) => void): void {
        const listeners = this.listeners[name] ?? [];

        listeners.push(listener);

        this.listeners[name] = listeners;
    }

    public dispatch(event: Event, name?: string): void {
        name = name ?? event.name;

        const listeners = this.listeners[name] ?? [];

        listeners.forEach(function (listener) {
            listener(event);
        });
    }
}
