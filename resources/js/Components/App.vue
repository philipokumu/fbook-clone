<template>
    <!-- Page layout codepen sample -->
    <!-- https://codepen.io/aliaadel/pen/rKZGzz -->
    <div class="flex flex-col flex-1 h-screen overflow-y-hidden" v-if="authUser">
        <Nav />

        <!-- <div class="flex overflow-y-hidden flex-1"> -->
            <!-- <Sidebar /> -->

            <!-- <div class="overflow-auto w-3/4"> -->
                <router-view :key="$route.fullPath"></router-view>
                
            <!-- </div>  -->
        <!-- </div> -->
    </div>
</template>

<script>
    import Nav from './Nav';
    import Sidebar from './Sidebar';
    import { mapGetters } from "vuex";

    export default {
        name: "App",

        components: {
            Nav,
            Sidebar,
        },

        data(){
            return {
                message:'',
            }
        },

        mounted(){
            this.$store.dispatch('fetchAuthUser');

        },

        created(){
            this.$store.dispatch('setPageTitle', this.$route.meta.title);
        },

        computed: {
            ...mapGetters({
               authUser: 'authUser' 
            }),
            send(){
                if (this.message) {
                    console.log(this.message);
                    this.message = '';
                }
            },
        },

        watch: {
            $route(to, from) {
                this.$store.dispatch('setPageTitle', to.meta.title);
            }
        }
    }
</script>

<style scoped>

</style>
