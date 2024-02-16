<script setup>
import {ref} from "vue";

const selectedFaq = ref(null);

const faqs = [
    {
        title: 'Faq 1',
        content: 'Faq Content 1'
    },
    {
        title: 'Faq 2',
        content: 'Faq Content 2'
    },
    {
        title: 'Faq 3',
        content: 'Faq Content 3'
    },
    {
        title: 'Faq 4',
        content: 'Faq Content 4'
    },
]

const toggleFaq = (index) => {
    selectedFaq.value = selectedFaq.value === index ? null : index;
}
</script>

<template>
    <div class="py-8 sm:py-16 px-8">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <p class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">FAQs</p>
                <p class="mt-6 text-lg leading-8">Have questions? We've got you covered! </p>
            </div>
        </div>
        <div class="mx-auto max-w-3xl mt-8">
            <div class="join join-vertical w-full">
                <div v-for="(faq, index) in faqs" :key="index"
                     class="collapse collapse-arrow join-item border border-base-300">
                    <input type="radio" :id="'faq-' + index" name="my-accordion" :checked="selectedFaq === index"/>
                    <div class="collapse-title text-xl font-medium" @click="toggleFaq(index)">
                        {{ faq.title }}
                    </div>
                    <div class="collapse-content" v-show="selectedFaq === index">
                        <p>{{ faq.content }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
