<template>
  <div>
    <li class="px-8 block rounded w-4/6" :class="'bg-'+coloring+'-100'">{{chatMessage}}</li>
    <hr>
    <div class="text-xs text-white">
        <span class="px-1 rounded" :class="'bg-'+coloring+'-500'">{{user}}</span>
    </div>
  </div>
</template>

<script>
export default {
    props: [
        'chatMessage',
        'user',
        'coloring',
    ]
}
</script>

<style>

</style>