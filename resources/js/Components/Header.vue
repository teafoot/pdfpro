<script setup>

</script>

<template>
    <div class="max-w-7xl m-auto navbar bg-base-100">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a :href="route('blog.index')">Blog</a></li>
                </ul>
            </div>
            <a href="/" class="flex flex-row items-center justify-center font-bold text-md">
                <img class="w-16" src="/images/logo.png" alt="PDF ChapterPro Logo">
                <span class="ml-2 text-xl">PDF ChapterPro</span>
            </a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a href="#features">Features</a></li>
                <li><a href="#pricing">Pricing</a></li>
                <li><a href="#faq">FAQ</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a :href="route('blog.index')">Blog</a></li>
            </ul>
        </div>
        <div class="navbar-end">
            <a :href="route('login')" class="btn btn-secondary">Get Started</a>
        </div>
    </div>
</template>

<style scoped>

</style>
