const state = {
    user: null,
    userStatus: null
};

const getters = {
    authUser: state => {
        return state.user;
    }
};

//Dispatches action, this is where the mounted logic is placed
const actions = {
    fetchAuthUser({commit, state}){
        axios.get('/api/auth-user')
        .then(res=>{
            commit('setAuthUser', res.data);
        })
        .catch(error=>{
            console.log('Cannot fetch user profile');
        });
    }
};

//Mutations is how we change the state
const mutations = {
    setAuthUser(state, user){
        state.user = user;
    }
};

export default {
    state, getters, actions, mutations
}
