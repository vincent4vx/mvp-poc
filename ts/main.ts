import App from './App';
import services from './services';

const layout: string|null = document.querySelector('html')?.dataset.layout ?? null;
const app = new App(document, services);

app.start();
