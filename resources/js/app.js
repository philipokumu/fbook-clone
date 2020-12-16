require('./bootstrap');

import vue from 'vue';
import router from './router';
import App from './Components/App';
import store from './Store';
import VideoChat from './Views/Video/VideoChat';

vue.component("VideoChat");

const app = new vue({
    el: '#app',

    components: {
        App, VideoChat
    },

    router,

    store
});
