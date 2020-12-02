<template>
  <div class="flex flex-col items-center" v-if="status.user === 'success' && user">
      <div class="relative mb-8">
          <div class="w-100 h-64 overflow-hidden">
            <UploadableImage image-width="1200"
                image-height="500" 
                location="cover" 
                :user-image="user.data.attributes.cover_image"
                classes="object-cover w-full cursor-pointer"
                alt="User background image"/>
          </div>
          <div class="absolute flex items-center bottom-0 left-0 -mb-8 ml-12 z-20">
              <div class="w-32">
                  <UploadableImage image-width="750"
                        image-height="750" 
                        location="profile" 
                        :user-image="user.data.attributes.profile_image"
                        classes="object-cover w-32 h-32 border-gray-200 rounded-full shadow-lg"
                        alt="User profile image"
                        class="cursor-pointer"/>
              </div>
              <p class="text-2xl text-gray-100 ml-4">{{user.data.attributes.name}}</p>
          </div>

        <div class="absolute flex items-center bottom-0 right-0 mb-4 mr-12 z-20">
            <button class="py-1 px-3 bg-gray-400 rounded" 
                v-if="friendButtonText && friendButtonText !== 'Accept'"
                @click="$store.dispatch('sendFriendRequest',$route.params.userId)">
                {{friendButtonText}}
            </button>
            <button class="mr-2 py-1 px-3 bg-blue-500 rounded" 
                v-if="friendButtonText && friendButtonText === 'Accept'"
                @click="$store.dispatch('acceptFriendRequest',$route.params.userId)">
                Accept
            </button>
            <button class="mr-2 py-1 px-3 bg-gray-400 rounded" 
                v-if="friendButtonText && friendButtonText === 'Accept'"
                @click="$store.dispatch('ignoreFriendRequest',$route.params.userId)">
                Ignore
            </button>
        </div>
      </div>

        <div v-if="status.posts==='loading'">Loading posts...</div>

        <div v-else-if="posts.data.length < 1">No posts found. Get started...</div>

        <Post v-for="(post,postKey) in posts.data" v-else :key="postKey" :post="post"/>

  </div>
</template>

<script>

import Post from "../../Components/Post";
import UploadableImage from"../../Components/UploadableImage";
import { mapGetters } from 'vuex';

export default {
    name: "Show",

    components: {
        Post,
        UploadableImage
    },

    mounted() {
        //Fetch specific user profile
        this.$store.dispatch('fetchUser', this.$route.params.userId);
        this.$store.dispatch('fetchUserPosts', this.$route.params.userId);

    },
    computed: {
        ...mapGetters({
            //These replace the otherwise data() field in individual components
            //They are now declared in vuex and are all initially null.
            user: 'user',
            posts: 'posts',
            status: 'status',
            friendButtonText: 'friendButtonText',

        })
    }

}
</script>

<style>

</style>