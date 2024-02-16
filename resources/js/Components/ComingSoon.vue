<script setup>

</script>

<template>
    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content flex w-full flex-col lg:flex-row-reverse">
            <div class="basis-1/3 card shadow-2xl bg-base-100">
                <form class="card-body">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email" placeholder="email" class="input input-bordered" required />
                    </div>
                    <div class="form-control mt-6">
                        <button class="btn btn-primary">Subscribe</button>
                    </div>
                </form>
            </div>
            <div class="basis-2/3 text-center lg:text-left">
                <h1 class="text-5xl font-bold">Coming Soon</h1>
                <p class="py-6">Subscribe to be notified once it's ready</p>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
