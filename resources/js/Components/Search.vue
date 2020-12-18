<template>
    <div class=" bg-white rounded shadow w-5/6 p-4">
        <div class="flex justify-between items-center">
            <div class="flex-1 flex mx-4">
                <input v-model="postMessage" type="text" name="body" class="w-full pl-4 h-8 bg-gray-200 rounded-full hover:bg-gray-300 
                    text-sm focus:outline-none focus:shadow-outline" placeholder="Search">
                    <transition name="fade">
                        <button 
                            v-if="postMessage"
                            @click="postHandler" 
                            class="bg-gray-200 ml-2 px-3 py-1 rounded-full">Search
                        </button>
                    </transition>
            </div>
        </div>

    </div>
</template>
<script>
import _ from "lodash";
import { mapGetters } from 'vuex';
import Dropzone from 'dropzone';

export default {
    data: ()=>{
        return {
            dropzone: null,
        };
    },
    mounted() {
        this.dropzone = new Dropzone(this.$refs.postImage, this.settings);
    },
    computed: {
        ...mapGetters({
            authUser: 'authUser',
        }),
       postMessage: {
        get() {
            return this.$store.getters.postMessage;
        },
        set: _.debounce(function (postMessage) {
            this.$store.commit('updateMessage',postMessage);
        }, 300),
       },

       settings(){
           return {
               paramName: 'image',
               url: '/api/posts',
               acceptedFiles: 'image/*',
               clickable: '.dz-clickable',
               autoProcessQueue: false,
               previewsContainer: '.dropzone-previews',
               maxFiles: 1,
               previewTemplate: document.querySelector('#dz-template').innerHTML,
               params: {
                   'width': 1000,
                   'height': 1000,
               },
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                },
               sending: (file,xhr,formData)=>{
                   formData.append('body', this.$store.getters.postMessage);
               }, 
               success: (event,res)=>{
                   this.dropzone.removeAllFiles();
                   this.$store.commit('pushPost',res);
               },
               maxfilesexceeded: file =>{
                   this.dropzone.removeAllFiles();
                   this.dropzone.addFile(file);
               }
           }
       },
    },

    methods: {
        postHandler(){
            if (this.dropzone.getAcceptedFiles().length){
                this.dropzone.processQueue();
            } else {
                this.$store.dispatch('postMessage');
            }

            this.$store.commit('updateMessage','');
        }
    }
    
}
</script>
<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }

</style>