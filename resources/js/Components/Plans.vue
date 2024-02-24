<script setup>

defineProps({currentSubscription: String})

const plans = [
    {
        name: 'Free',
        slug: 'free',
        description: 'Individuals or small businesses with moderate social media needs.',
        price: '0',
        interval: 'month',
        features: [
            'Feature 1',
            'Feature 2',
            'Feature 3',
            'Feature 4',
            'Feature 5',
        ],
        // productId: 1,
        // variantId: 1,
    },
    {
        name: 'Starter',
        slug: 'starter', // used by stripe, should be your stripe price id
        description: 'Individuals or small businesses with moderate social media needs.',
        price: '9.99',
        interval: 'month',
        features: [
            'Everything in free',
            'Feature 6',
            'Feature 7',
            'Feature 8',
        ],
        // productId: 193449, // for lemonsqueezy only
        // variantId: 255829, // for lemonsqueezy only
    },
    {
        name: 'Pro',
        slug: 'pro', // used by stripe, should be your stripe price id
        description: 'Professional bloggers, influencers, or mid-sized businesses.',
        price: '19.99',
        interval: 'month',
        features: [
            'Everything in "Pro"',
            'Feature 9',
            'Feature 10',
            'Feature 11',
        ],
        // productId: 193449, // for lemonsqueezy only
        // variantId: 255829, // for lemonsqueezy only
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
                <a :href="$page.props.auth.user ? route('stripe.subscription.checkout', {productId: plan.productId, variantId: plan.variantId}) : route('register')"
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
