require('./bootstrap');

import vue from 'vue';
import router from './router';
import App from './Components/App';
import store from './Store';

const app = new vue({
    el: '#app',

    components: {
        App
    },

    router,

    store
});
