import { startCase } from 'lodash';
import vue from 'vue';
import vueRouter from 'vue-router';
import NewsFeed from './Views/NewsFeed';
import UserShow from './Views/Users/Show';
import VideoChatPage from './Views/VideoChatPage';
import CategoryPage from './Views/CategoryPage';
import LandingPage from './Views/LandingPage';

vue.use(vueRouter);

export default new vueRouter({
    mode: 'history', //remove # or $ infront of every address

    // Routes for different layouts
    // https://dev.to/lampewebdev/vuejs-pages-with-dynamic-layouts-problems-and-a-solution-4460
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
            path: '/videochat', name: 'videochat', component: VideoChatPage,
            meta: {title: 'Video Chat'}
        },

        {
            path: '/category', name: 'category', component: CategoryPage,
            meta: {title: 'Category'}
        },

        {
            path: '/landing', name: 'category', component: LandingPage,
            meta: {title: 'Landing'}
        }

    ]
});

