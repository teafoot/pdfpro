<script setup>

defineProps({currentSubscription: String})

const plans = [
    {
        name: 'Basic',
        slug: 'basic',
        description: 'Ideal for individuals or small businesses with basic PDF splitting needs.',
        price: '0',
        interval: 'month',
        features: [
            'Split up to 5 PDFs per month',
            'Access to basic bookmark detection',
            'Download individual chapters',
            'Email support',
            'Community access',
        ],
    },
    {
        name: 'Standard',
        slug: 'standard', // used by stripe, should be your stripe price id
        description: 'Perfect for regular users with advanced splitting requirements.',
        price: '14.99',
        interval: 'month',
        features: [
            'Split up to 50 PDFs per month',
            'Advanced bookmark detection',
            'Batch download of chapters',
            'Priority email support',
            'No ads',
        ],
    },
    {
        name: 'Premium',
        slug: 'premium', // used by stripe, should be your stripe price id
        description: 'Designed for professionals and businesses with high-volume processing.',
        price: '29.99',
        interval: 'month',
        features: [
            'Unlimited PDF splits per month',
            'Premium bookmark detection with AI assistance',
            'API access for automated workflows',
            'Dedicated customer support',
            'Custom branding for split PDFs',
        ],
    },
];
</script>

<template>
    <div id="pricing" class="py-8 sm:py-16 px-8">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <p class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">Choose Your Plan</p>
                <p class="mt-6 text-lg leading-8">Select the perfect plan that fits your social media needs. Start with our <b>7</b> days free trial and upgrade anytime to unlock more powerful features</p>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mx-auto max-w-6xl my-8">
            <div v-for="plan in plans" class="px-8 py-12 border border-base-200 rounded-3xl shadow-xl hover:shadow-2xl cursor-pointer">
                <p class="text-3xl font-extrabold mb-2">{{ plan.name }}</p>
                <p class="mb-6">
                    <span>Best For: </span> <span>{{ plan.description }}</span></p>
                <p class="mb-6">
                    <span class="text-4xl font-extrabold">${{ plan.price }}</span>
                    <span v-if="plan.price !== '0'" class="text-base font-medium">/{{ plan.interval }}</span>
                </p>
                <a v-if="plan.price !== '0'" :href="$page.props.auth.user ? route('stripe.subscription.checkout', {price: plan.slug}) : route('register')"
                   class="mb-6 btn btn-secondary btn-wide text-center mx-auto flex">
                    Choose Plan
                </a>
                <a v-else :href="route('register')"
                   class="mb-6 btn btn-secondary btn-wide text-center mx-auto flex">
                    Choose Plan
                </a>
                <p class="text-sm mb-4">*7 Days Free Trial</p>
                <ul>
                    <li v-for="feature in plan.features" class="flex">
                        - {{ feature }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
