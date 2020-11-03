const state = {
    newsPosts: null,
    newsPostsStatus: null,
    postMessage: '',
};

const getters = {
    newsPosts: state => {
        return state.newsPosts;
    },
    newsStatus: state => {
        return {
            newsPostsStatus: state.newsPostsStatus,
        };
    },
    postMessage: state => {
        return state.postMessage;
    },
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
    },
    postMessage({commit, state}){
        commit('setPostsStatus', 'loading');

        axios.post('/api/posts', {body: state.postMessage})
            .then(res => {
                commit('pushPost', res.data);
                commit('updateMessage', '');
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
    },
    updateMessage(state, message){
        state.postMessage = message;
    },
    pushPost(state, post){
        state.newsPosts.data.unshift(post);
    },

};

export default {
    state, getters, actions, mutations
}
