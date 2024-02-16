<script setup>

import Ratings from "@/Components/Ratings.vue";
</script>

<template>
    <div class="hero min-h-screen bg-base-100">
        <div class="hero-content flex-col lg:flex-row">
            <div class="basis-2/3">
                <h1 class="text-7xl font-bold">Ship your startup in days, not weeks <br>with <span class="text-secondary">Laravel</span></h1>
                <p class="mt-6">Laravel Starter Kit is your straightforward Laravel Jetstream, Tailwind,
                    Inertia.js, Vue boilerplate. Streamline your SaaS app development with ready-to-go components for
                    payments, emails, and more. </p>
                <p class="mt-2 mb-6 tracking-wide">Make development simple and swift with Laravel Starter Kit</p>
                <button class="btn btn-primary btn-widest text-lg text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z"/>
                    </svg>
                    Get Laravel Starter Kit
                </button>
                <Ratings/>
            </div>
            <div class="basis-1/3">
                <img src="/images/hero.jpg" class="rounded-lg" alt=""/>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
