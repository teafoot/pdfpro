<script setup>

import {Head} from '@inertiajs/vue3';
import Header from "@/Components/Header.vue";
import Copyright from "@/Components/Copyright.vue";
import Footer from "@/Components/Footer.vue";
import Seo from "@/Components/Seo.vue";
import Banner from "@/Components/Profile/Banner.vue";
</script>

<template>
    <Banner />

    <Head title="Your default title goes here">
        <meta head-key="description" name="description" content="Your default description goes here">
        <meta head-key="keywords" name="keywords" content="Your default keywords goes here">
        <!-- Twitter Card Tags -->
        <meta head-key="twitter:card" name="twitter:card" content="summary_large_image">
        <meta head-key="twitter:title"  name="twitter:title" content="Your default title goes here">
        <meta head-key="twitter:description" name="twitter:description" content="Your default description goes here">
        <meta head-key="twitter:image" name="twitter:image" content="twitterimage.png">
        <meta head-key="twitter:site" name="twitter:site" content="@yourtwitterhandle">
        <!-- OG-->
        <meta head-key="og:title"  name="og:title" content="Your default title goes here">
        <meta head-key="og:description" name="og:description" content="Your default description goes here">
        <meta name="og:image" content="twitterimage.png">
    </Head>
    <Header/>
    <!--    Page Content -->
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <slot/>
    </div>
    <!--    End Page Content-->
    <Footer/>
    <Copyright/>
</template>

<style scoped>

</style>
