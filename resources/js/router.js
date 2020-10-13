import { startCase } from 'lodash';
import vue from 'vue';
import vueRouter from 'vue-router';
import Start from './Views/Start';

vue.use(vueRouter);

export default new vueRouter({
    mode: 'history', //remove # or $ infront of every address

    routes: [
        {
            path: '/', name: 'home', component: Start,
        }
]
});

