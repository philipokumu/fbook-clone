import vue from 'vue';
import vuex from 'vuex'
import User from './modules/user'
import title from './modules/title'
import profile from './modules/profile'
import posts from './modules/posts'

vue.use(vuex)

export default new vuex.Store({
    modules: {
        User, title, profile, posts
    }
})

