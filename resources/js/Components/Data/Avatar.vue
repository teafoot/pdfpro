<script setup>
defineProps({
    src: String,
    alt: String
})
</script>

<template>
    <div class="avatar">
        <div class="w-24 rounded-full">
            <img :src="src"  :alt="alt ?? src"/>
        </div>
    </div>
</template>

<style scoped>

</style>
