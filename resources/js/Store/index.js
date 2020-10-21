import Vue from 'vue';
import Vuex from 'vuex'
import user from './modules/user'

Vue.use(Vuex)

export default new vuex.Store({
    modules: {
        user,
    }
})

