import vue from 'vue';
import vuex from 'vuex';
import User from './modules/user';
import title from './modules/title';
import profile from './modules/profile';
import posts from './modules/posts';
import VueChatScroll from 'vue-chat-scroll';;

vue.use(VueChatScroll)
vue.use(vuex)

export default new vuex.Store({
    modules: {
        User, title, profile, posts
    }
})

