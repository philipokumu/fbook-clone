<template>
  <div class="absolute bottom-0 mx-5">
      <div class=" bg-white w-64">
            <div class="bg-blue-500 px-8 rounded-t">John Doe Chat</div>
        <ul class=" overflow-y-scroll h-64" v-chat-scroll>
            <chat-message v-for="(chatMessage, messageKey) in chat.message" 
            :key="messageKey" 
            :chatMessage="chatMessage"
            :coloring="chat.coloring"
            :user="chat.user[messageKey]"/>
            
        </ul>
        <input class="px-4 w-full" placeholder="Type your message.." v-model="message" @keyup.enter="send()">
      </div>
  </div>
</template>

<script>
import ChatMessage from './ChatMessage.vue';
export default {
  components: { ChatMessage },
    data(){
        return {
            message:'',
            chat: {
                message: [],
                user: [],
                coloring: [],
            }
        }
    },
    mounted(){
            this.$store.dispatch('fetchAuthUser');
            this.listen();
        },
    methods: {
        send(){
            if (this.message) {
                this.chat.message.push(this.message);
                this.chat.user.push('you');
                this.chat.coloring.push('green');

                axios.post('/send',{message: this.message})
                .then(res => {
                    console.log(res);
                    this.message = '';
                })
                .catch(error =>{
                    console.log(error);
                });
            }
        },
        listen(){
            Echo.private('chat')
            .listen('ChatEvent',(e)=>{
                this.chat.message.push(e.message);
                this.chat.user.push(e.user_name);
                this.chat.coloring.push('red');
            })
        }
    }
}
</script>

<style>

</style>