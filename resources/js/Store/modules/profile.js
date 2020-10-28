//Default data
const state = {
    user: null,
    userStatus: null
};

//Get data from vuex state to component
const getters = {
    user: state => {
        return state.user;
    }
};

//Dispatches action, this is where the mounted logic is placed. Actions can be asynchronous.
//Get data from database
const actions = {
    fetchUser({commit, state}, userId){
        commit ('setUserStatus','loading');

        //Fetch specific user profile
        axios.get('/api/users/' + userId)
        .then (res => {
           commit('setUser', res.data);
           commit ('setUserStatus','success');
        })
        .catch(error=>{
            console.log('Unable to fetch user from the server');
            commit ('setUserStatus','error');
        });

    }
};

//Mutations is how we change the state. And can be traced on frontend. Unlike using only getters. Are synchronous
//For monitoring what mutation changed the state. Cant do that from action
const mutations = {
    setUser(state, user){
        state.user = user;
    },
    setUserStatus(state, status){
        state.userStatus = status;
    }
};

export default {
    state, getters, actions, mutations
}
