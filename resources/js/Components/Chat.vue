<template>
  <div class="absolute bottom-0 mx-5">
      <div class=" bg-white w-64">
            <div class="bg-blue-500 px-8">John Doe Chat</div>
        <ul class=" overflow-y-scroll h-64">
            <chat-message v-for="(chatMessage, messageKey) in chat.message" :key="messageKey" :chatMessage="chatMessage"/>
            
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
            }
        }
    },
    methods: {
        send(){
            if (this.message) {
                this.chat.message.push(this.message);
                this.message = '';
            }
        }
    }
}
</script>

<style>

</style>