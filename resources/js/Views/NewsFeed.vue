<template>
    <div class="flex">
        <div class="flex flex-col items-center py-4 w-3/4">
            <NewPost />
            <p v-if="newsStatus==='loading'">Loading posts...</p>

            <Post v-for="(post, postKey) in posts.data" v-else :key="postKey" :post="post"/>

            <p v-if="newsStatus!=='loading' && posts.data.length < 1">No posts found</p>

        </div>
        <div class="w-1/4">
            <TextChat />
        </div>    
    </div> 
</template>

<script>
import NewPost from '../Components/NewPost';
import TextChat from '../Components/TextChat';
import Post from '../Components/Post';
import { mapGetters } from "vuex";

export default {
    name: "NewsFeed",

    components: {
        NewPost, Post, TextChat,
    },

    created() {
        this.$store.dispatch('fetchNewsPosts');
    },

    computed: {
        ...mapGetters ({
            posts: 'posts',
            newsStatus: 'newsStatus'
        })
    }
}
</script>

<style scoped>

</style>