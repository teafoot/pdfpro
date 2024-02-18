<script setup>
import { Head } from '@inertiajs/vue3';
import Header from '@/Components/Header.vue';
import Hero from "@/Components/Hero.vue";
import Partners from "@/Components/Partners.vue";
import ContentWithImage from "@/Components/ContentWithImage.vue";
import Footer from "@/Components/Footer.vue";
import Copyright from "@/Components/Copyright.vue";
import Plans from "@/Components/Plans.vue";
import Faq from "@/Components/Faq.vue";
import CTA from "@/Components/CTA.vue";
import Seo from "@/Components/Seo.vue";
import HomeLayout from "@/Layouts/HomeLayout.vue";
import ComingSoon from "@/Components/ComingSoon.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

</script>

<template >
    <ComingSoon/>
    <HomeLayout>
        <Seo title="LaraFast" description="Ship Your SaaS Faster with LaraFast"/>

        <Hero/>
        <Partners/>
        <ContentWithImage/>
        <Plans/>
        <Faq/>
        <CTA/>
    </HomeLayout>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
