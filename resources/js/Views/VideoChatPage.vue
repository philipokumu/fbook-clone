<template>
  <div>
      <video-chat :allUsers="allUsers" :authUserId="authUser.data.user_id" :turn_url="turn.url"
        :turn_username="turn.username" :turn_credential="turn.credential" />
  </div>
</template>

<script>
import VideoChat from "../Components/VideoChat";
import { mapGetters } from 'vuex';

export default {

    components: {
        VideoChat,
    },

    data(){
        return {
            turn: {
                url: process.env.MIX_TURN_SERVER_URL,
                credential: process.env.MIX_TURN_SERVER_CREDENTIAL,
                username: process.env.MIX_TURN_SERVER_USERNAME,
            },
            allUsers: [
                {name: 'James', id: 1},
                {name: 'Jane', id: 2},
                {name: 'June', id: 4},
                {name: 'John', id: 5},
            ],
        }
    },
    computed: {
        ...mapGetters({
            authUser: 'authUser',
        }),
    }

}
</script>

<style>

</style>