<template>
    <div class="flex overflow-y-hidden flex-1">
        <Sidebar />

        <div class="overflow-auto w-3/4">
            <router-view />
        </div>
    </div>
</template>

<script>
import Sidebar from '../Components/Sidebar';
export default {
    components: {
            Sidebar,
        },
}
</script>

<style>

</style>