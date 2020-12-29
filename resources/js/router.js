import { startCase } from 'lodash';
import vue from 'vue';
import vueRouter from 'vue-router';
import NewsFeed from './Views/NewsFeed';
import UserShow from './Views/Users/Show';
import VideoChatPage from './Views/VideoChatPage';
import CategoryPage from './Views/CategoryPage';
import LandingPage from './Views/LandingPage';
import WidthWithLeftSidebar from './layouts/WidthWithLeftSidebar';
import FullWidth from './layouts/FullWidth';

vue.use(vueRouter);

export default new vueRouter({
    mode: 'history', //remove # or $ infront of every address

    // Routes with different layouts
    // https://dev.to/lampewebdev/vuejs-pages-with-dynamic-layouts-problems-and-a-solution-4460
    routes: [
        //Layout 1
        {
            path: '',
            component: FullWidth,
            children: [
                {
                    path: '/', name: 'home', component: LandingPage,
                    meta: {title: 'home'}
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
        
            ]
        },
        //Layout 2
        {
            path: '',
            component: WidthWithLeftSidebar,
            children: [
                {
                    path: '/newsfeed', name: 'newsfeed', component: NewsFeed,
                    meta: {title: 'News Feed'}
                },
            ]
        },

    ]
});

