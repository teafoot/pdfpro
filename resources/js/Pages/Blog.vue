<script setup>

import HomeLayout from "@/Layouts/HomeLayout.vue";
import Seo from "@/Components/Seo.vue";
import moment from 'moment';

defineProps({
    articles: Array
})
</script>

<template>
    <HomeLayout>
        <Seo title="Blog" description="LaraFast Blog"/>
        <div class="bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:mx-0">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Blog</h2>
                    <p class="mt-2 text-lg leading-8 text-gray-600">Welcome to our blog</p>
                </div>
                <div class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    <article v-for="article in articles" class="cursor-pointer flex max-w-xl flex-col items-start justify-between">
                        <div class="rounded-xl h-52 w-full overflow-hidden shadow-md">
                            <img class="object-contain object-center" :src="article.icon" alt="">
                        </div>
                        <div class="flex items-center gap-x-4 text-xs mt-4">
                            <time datetime="2020-03-16" class="text-gray-500">{{ moment(article.created_at).format('MMM Do, YYYY, HH:mm')}}</time>
                        </div>
                        <div class="group relative">
                            <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                <a :href="route('blog.article', {'article': article.slug})">
                                    <span class="absolute inset-0"></span>
                                    {{ article.title }}
                                </a>
                            </h3>
                            <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">
                                {{ article.seo_description }}
                            </p>
                        </div>
                        <div class="relative mt-8 flex items-center gap-x-4">
                            <img :src="article.user.profile_photo_url" alt="" class="h-10 w-10 rounded-full bg-gray-50">
                            <div class="text-sm leading-6">
                                <p class="font-semibold text-gray-900">
                                    <a href="#">
                                        <span class="absolute inset-0"></span>
                                        {{ article.user.name }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </article>

                    <!-- More posts... -->
                </div>
            </div>
        </div>
    </HomeLayout>
</template>

<style scoped>

</style>
