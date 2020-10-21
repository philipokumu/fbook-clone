require('./bootstrap');

import Vue from 'vue';
import router from './router';
import App from './Components/App';
import store from './store';

const app = new Vue({
    el: '#app',

    components: {
        App
    },

    router,

    store
});
