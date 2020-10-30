const state = {
    newsPosts: null,
    newsPostsStatus: null
};

const getters = {
    newsPosts: state => {
        return state.posts;
    },
    newsStatus: state => {
        return {
            newsPostsStatus: state.newsPostsStatus,
        };
    }
};

//Dispatches action, this is where the mounted logic is placed. Actions can be asynchronous.
const actions = {
    fetchNewsPosts({commit, state}){
        commit('setPostsStatus', 'loading');

        axios.get('/api/posts')
            .then(res => {
                commit('setPosts', res.data);
                commit('setPostsStatus', 'success');
            })
            .catch(error =>{
                commit('setPostsStatus', 'error');
            });
    }
};

//Mutations is how we change the state. And can be traced on frontend. Unlike using only getters. Are synchronous
const mutations = {
    setPostsStatus(state, status){
        state.newsPostsStatus = status;
    },

    setPosts(state, posts){
        state.newsPosts = posts;
    }
};

export default {
    state, getters, actions, mutations
}
