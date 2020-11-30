const state = {
    posts: null,
    postsStatus: false,
    postMessage: '',
};

const getters = {
    posts: state => {
        return state.posts;
    },
    newsStatus: state => {
        return {
            postsStatus: state.postsStatus,
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
    },
    likePost({commit, state}, data){
        axios.post('/api/posts/'+ data.postId + '/like')
            .then(res => {
                commit('pushLikes', {likes: res.data, postKey: data.postKey});
            })
            .catch(error =>{
                // commit('setPostsStatus', 'error');
            });
    },
    commentPost({commit, state}, data){
        axios.post('/api/posts/'+ data.postId + '/comment',{body: data.body})
            .then(res => {
                commit('pushComments', {comments: res.data, postKey: data.postKey});
            })
            .catch(error =>{
                // commit('setPostsStatus', 'error');
            });
    },

    //Loaded when loading a profile
    fetchUserPosts({commit, dispatch}, userId){
        commit ('setPostsStatus','loading');

        //Fetch specific user posts for their profile
        axios.get('/api/users/'+ userId + '/posts')
            .then(res => {
            commit('setPosts', res.data);
            commit ('setPostsStatus','success');
        })
        .catch(error=>{
            console.log('Unable to fetch user from the server');
            commit ('setPostsStatus','error');
        });
    },
};

//Mutations is how we change the state. And can be traced on frontend. Unlike using only getters. Are synchronous
const mutations = {
    setPostsStatus(state, status){
        state.postsStatus = status;
    },

    setPosts(state, posts){
        state.posts = posts;
    },
    updateMessage(state, message){
        state.postMessage = message;
    },
    pushPost(state, post){
        state.posts.data.unshift(post);
    },
    pushLikes(state, data){
        state.posts.data[data.postKey].data.attributes.likes = data.likes;
    },
    pushComments(state, data){
        state.posts.data[data.postKey].data.attributes.comments = data.comments;
    },

};

export default {
    state, getters, actions, mutations
}
