//Default data
const state = {
    user: null,
    userStatus: false,
};

//Get data from vuex state to component
const getters = {
    //For loading a user profile
    user: state => {
        return state.user;
    },
    status: state => {
        return {
            user: state.userStatus,
            posts: state.postsStatus,
        };
    },
    //For ease of loading a profile with a friendship relationship attached
    friendship: state => {
        return state.user.data.attributes.friendship;
    },

    //For button text based on the friendship relationship. Since there are two defaults, 
    //no need to place it in state
    friendButtonText: (state, getters, rootState)=>{
        //Check that the user's profile is not the authenticated user
        if (getters.user.data.user_id === rootState.User.user.data.user_id) {
            return '';
        }
        //if No friendship between the 2 users
        else if (getters.friendship === null) {
            return 'Add friend';
        }
        //If there is a friend request sent out,
        //and the authenticated user is the one who sent the friend request
        else if (getters.friendship.data.attributes.confirmed_at === null 
            && getters.friendship.data.attributes.friend_id !== rootState.User.user.data.user_id){
            return 'Pending friend request';
        }
        //If the friend request is already confirmed with a timestamp
        else if (getters.friendship.data.attributes.confirmed_at !== null ) {
            return '';
        }
        //Otherwise the default is that you are the friend requested user
        return 'Accept';
    }
};

//Dispatches action, this is where the mounted logic is placed. Actions can be asynchronous.
//Get data from database
const actions = {

    //Loaded when loading a profile
    async fetchUser({commit, dispatch}, userId){
        commit ('setUserStatus','loading');

        //Fetch specific user profile
        await axios.get('/api/users/' + userId)
        .then (res => {
           commit('setUser', res.data);
           commit ('setUserStatus','success');
        })
        .catch(error=>{
            console.log('Unable to fetch user from the server');
            commit ('setUserStatus','error');
        });
    },

    //Loaded when friend request button is clicked
    async sendFriendRequest({commit,getters}, friendId) {   
        //First check that you are not sending the request twice
        if (getters.friendButtonText !== 'Add friend') {
            return;
        }
        // Send the friend request to the api database
        await axios.post('/api/friend-request/',{'friend_id': friendId})
        .then (res => {
            commit ('setUserFriendship',res.data);
        })
        .catch(error=>{
        });
    },

    async acceptFriendRequest({commit,state}, userId) {     
        // Send the accept friend request response to the api database
        await axios.post('/api/friend-request-response/',{'user_id': userId, 'status': 1})
        .then (res => {
            commit ('setUserFriendship',res.data);
        })
        .catch(error=>{
        });
    },

    async ignoreFriendRequest({commit,state}, userId) {     
        // Send the ignore friend request response to the api database
        await axios.delete('/api/friend-request-response/delete',{ data: {'user_id': userId}})
        .then (res => {
            commit ('setUserFriendship',null);
        })
        .catch(error=>{
        });
    },

};

//Mutations is how we change the state. And can be traced on frontend. Unlike using only getters. Are synchronous
//For monitoring what mutation changed the state. Cant do that from action
const mutations = {
    //When profile is loaded, user (originally null) is set
    setUser(state, user){
        state.user = user;
    },
    //Also set alongside user but this takes care of the current friendship between authenticated user and the other user
    setUserFriendship(state,friendship){
        state.user.data.attributes.friendship = friendship;
    },
    //Loaded as a result of opening any user profile
    setUserStatus(state, status){
        state.userStatus = status;
    },
};

export default {
    state, getters, actions, mutations
}
