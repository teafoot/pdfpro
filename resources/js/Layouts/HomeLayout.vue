<script setup>

import Header from "@/Components/Header.vue";
import Copyright from "@/Components/Copyright.vue";
import Footer from "@/Components/Footer.vue";
import Seo from "@/Components/Seo.vue";
import Banner from "@/Components/Profile/Banner.vue";
</script>

<template>
    <Banner />

    <Seo title="My app" description="his is the default description">
        <!-- Twitter Card Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Ship Faster with Larafast - Laravel Starter Kit">
        <meta name="twitter:description" content="Boost your startup with Larafast - Laravel Starter Kit - a powerful solution for efficiency, speed, and success in your entrepreneurial journey. Transform your idea into reality in just a matter of days.">
        <!-- Add your Twitter handle below -->
        <meta name="twitter:site" content="@yourTwitterHandle">
        <meta name="twitter:image" content="/images/hero.jpeg">
    </Seo>
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
