<template>
    <div class="flex flex-col items-center py-4">
        <NewPost />
        <p v-if="loading">Loading posts...</p>
        <Post v-for="post in posts.data" v-else :key="post.data.post_id" :post="post"/>

        <p v-if="! loading && posts.data.length < 1">No posts found</p>

    </div>
</template>

<script>
import NewPost from '../Components/NewPost';
import Post from '../Components/Post';

export default {
    name: "NewsFeed",

    components: {
        NewPost, Post
    },

    data: () => {
        return {
            posts: null,
            loading: true,
        }
    },

    mounted() {
        axios.get('/api/posts')
            .then(res => {
                this.posts = res.data;
            })
            .catch(error =>{
                console.log("Unable to fetch data");
            })
            .finally(()=>{
            this.loading = false;
            });

    }
    
}
</script>

<style scoped>

</style>