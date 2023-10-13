import App from './App';
import PJax from './PJax';
import { Layout } from './Layout';
import { Post } from './Post';
import Chat from './Chat';

export default (app: App) => {
    return [
        new PJax(app),
        new Layout(app.dom),
        new Post(app.dom),
        new Chat(app),
    ];
};
