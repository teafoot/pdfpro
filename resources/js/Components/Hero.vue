<script setup>

import Ratings from "@/Components/Ratings.vue";
</script>

<template>
    <div class="hero min-h-screen bg-base-100">
        <div class="hero-content flex-col lg:flex-row-reverse">
            <div class="basis-1/3">
                <img src="/images/pdf-hero.jpg" class="rounded-lg shadow-2xl" alt="PDF Chapters"/>
            </div>
            <div class="basis-2/3">
                <h1 class="text-5xl sm:text-7xl font-bold">Effortlessly Split PDFs into Chapters <br>with <span class="text-secondary">PDF ChapterPro</span></h1>
                <p class="mt-6">Our platform simplifies the process of dividing your PDF documents into manageable sections, based on bookmarks, with just a few clicks.</p>
                <p class="mt-2 mb-6 tracking-wide">Experience the convenience of automated PDF organization and streamline your document handling workflow.</p>
                <button class="btn btn-secondary btn-widest text-lg text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z"/>
                    </svg>
                    Start Splitting PDFs
                </button>
                <Ratings/>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
