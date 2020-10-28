import vue from 'vue';
import vuex from 'vuex'
import user from './modules/user'
import title from './modules/title'
import profile from './modules/profile'

vue.use(vuex)

export default new vuex.Store({
    modules: {
        user, title, profile
    }
})

