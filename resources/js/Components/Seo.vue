<script setup>
import {Head} from '@inertiajs/vue3';

defineProps({
    title: String,
    description: String,
    keywords: String,
    canonical: String,
})
</script>

<template>
    <Head>
        <title v-if="title">{{ title }}</title>
        <meta v-if="description" head-key="description" name="description" :content="description">
        <meta v-if="keywords" head-key="keywords" name="keywords" :content="keywords">
        <link rel="canonical" :href="canonical ?? $page.url">

        <slot/>
    </Head>
</template>

<style scoped>

</style>
