import { startCase } from 'lodash';
import vue from 'vue';
import vueRouter from 'vue-router';
import NewsFeed from './Views/NewsFeed';
import UserShow from './Views/Users/Show';
import VideoChat from './Views/Video/VideoChat';

vue.use(vueRouter);

export default new vueRouter({
    mode: 'history', //remove # or $ infront of every address

    routes: [
        {
            path: '/', name: 'home', component: NewsFeed,
            meta: {title: 'News Feed'}
        },

        {
            path: '/users/:userId', name: 'user.show', component: UserShow,
            meta: {title: 'Profile'}
        },

        {
            path: '/videochat', name: 'videochat', component: VideoChat,
            meta: {title: 'Video Chat'}
        }
    ]
});

