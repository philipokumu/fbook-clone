<template>
  <div class="flex flex-col items-center">
      <div class="relative mb-8">
          <div class="w-100 h-64 overflow-hidden">
            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c8/Untersberg_Mountain_Salzburg_Austria_Landscape_Photography_%28256594075%29.jpeg" 
                alt="User Background image" class=" object-cover w-full">
          </div>
          <div class="absolute flex items-center bottom-0 left-0 -mb-8 ml-12 z-20">
              <div class="w-32">
                  <img src="https://cdn.pixabay.com/photo/2014/07/09/10/04/man-388104_960_720.jpg" 
                  class=" object-cover w-32 h-32 border-gray-200 rounded-full shadow-lg" alt="User profile image">
              </div>
              <p class="text-2xl text-gray-100 ml-4">{{user.data.attributes.name}}</p>
          </div>
      </div>

        <p v-if="postLoading">Loading posts...</p>

        <Post v-for="post in posts.data" v-else :key="post.data.post_id" :post="post"/>

        <p v-if="! postLoading && posts.data.length < 1">No posts found. Get started...</p>
  </div>
</template>

<script>

import Post from "../../Components/Post";

export default {
    name: "Show",

    components: {
        Post,
    },

    data: ()=> {
        return {
            user: null,
            posts: null,
            userLoading: true,
            postLoading: true,
        }
    },

    mounted() {
        //Fetch specific user profile
        axios.get('/api/users/' + this.$route.params.userId)
        .then (res => {
            this.user = res.data;
        })
        .catch(error=>{
            console.log('Unable to fetch user from the server');
        })
        .finally(()=>{
            this.userLoading = false;
        });

        //Fetch specific user posts for their profile
        axios.get('/api/users/' + this.$route.params.userId + '/posts')
            .then(res => {
                this.userPosts = res.data;

            })
            .catch(error =>{
                console.log("Unable to fetch data");
            })
            .finally(()=>{
            this.postLoading = false;
            });
    }

}
</script>

<style>

</style>