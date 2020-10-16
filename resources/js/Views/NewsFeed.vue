<template>
    <div class="flex flex-col items-center py-4">
        <NewPost />
        <p v-if="loadingState">Loading posts...</p>
        <Post v-for="post in posts.data" v-else :key="post.data.post_id" :post="post"/>

    </div>
</template>

<script>
import NewPost from '../components/NewPost';
import Post from '../components/Post';

export default {
    name: "NewsFeed",

    components: {
        NewPost, Post
    },

    data: () => {
        return {
            posts: null,
            loadingState: true,
        }
    },

    mounted() {
        axios.get('/api/posts')
            .then(res => {
                this.posts = res.data;
                this.loadingState = false;

            })
            .catch(error =>{
                console.log("Unable to fetch data");
                this.loadingState = false;
            })

    }
    
}
</script>

<style scoped>

</style>