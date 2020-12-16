<template>
  <div>
    <li class="px-8 block rounded w-5/6 bg-green-100" v-if="user=='you'">{{chatMessage}}
    <small class="block">{{time}}</small>
    </li>
    <li class="px-8 block rounded w-5/6 bg-red-100" v-else>{{chatMessage}}
    <small class="block text-xs">{{time}}</small>
    </li>
    
    <hr>
    <div class="text-xs text-white">
        <span class="px-1 rounded bg-green-500" v-if="user=='you'">{{user}}</span>
        <span class="px-1 rounded bg-red-500" v-else>{{user}}</span>
    </div>
  </div>
</template>

<script>
export default {
    props: [
        'chatMessage',
        'user',
        'time',
    ]
}
</script>

<style>

</style>