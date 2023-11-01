import App from './App';
import PJax from './PJax';
import { Layout } from './Layout';
import { Post } from './Post';
import Chat from './Chat';
import UsersList from './BackOffice/UsersList';

export default (app: App) => {
    return [
        new PJax(app, {
            defaultTitle: 'My Blog',
            noPjaxSelector: '.no-pjax'
        }),
        new Layout(app.dom, app),
        new Post(app.dom),
        new Chat(app),
        new UsersList(app),
    ];
};
