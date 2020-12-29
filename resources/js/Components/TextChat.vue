<template>
  <div class="absolute bottom-0">
      <div class=" bg-white w-56">
            <div class="bg-blue-500 px-8 rounded-t">Chat</div>
            <ul class=" overflow-y-scroll h-64" v-chat-scroll>
                <text-chat-message v-for="(chatMessage, messageKey) in chat.message" 
                :key="messageKey" 
                :chatMessage="chatMessage"
                :time="chat.time[messageKey]"
                :user="chat.user[messageKey]"/>
                
            <div class="px-4 rounded inline text-sm bg-green-100" v-if="typing">{{typing}}</div>
            </ul>
        <input class="px-4 w-full hover:bg-gray-200 h-10 focus:outline-none focus:shadow-outline" 
            placeholder="Type your message.." v-model="message" 
            @keyup.enter="send()">
      </div>
  </div>
</template>

<script>
import TextChatMessage from './TextChatMessage.vue';
export default {
  components: { TextChatMessage },
    data(){
        return {
            message:'',
            chat: {
                message: [],
                user: [],
                time: [],
            },
            typing: '',
        }
    },
    watch:{
        message(){
            Echo.private('chat')
            .whisper('typing', {
                name: this.message
            });
        }
    },
    mounted(){
            this.listen();
        },
    methods: {
        async send(){
            if (this.message) {
                this.chat.message.push(this.message);
                this.chat.user.push('you');
                let today = new Date();
                this.chat.time.push(today.getHours() + ":" + today.getMinutes());

                await axios.post('/api/send',{message: this.message})
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
                    let today = new Date();
                    this.chat.time.push(today.getHours() + ":" + today.getMinutes());
                })
                .listenForWhisper('typing', (e) => {
                    if (e.name != ''){
                        this.typing = 'typing...'
                    }
                    else {
                        this.typing = ''
                    }
                });
        }
    }
}
</script>

<style>

</style>