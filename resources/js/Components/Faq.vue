<script setup>
import {ref} from "vue";

const selectedFaq = ref(null);

const faqs = [
    {
        title: 'How does the PDF splitting process work?',
        content: 'Our service analyzes your uploaded PDF for bookmarks indicating chapters and automatically splits the document into separate PDFs for each chapter. You can then download the individual chapter files directly from your dashboard.'
    },
    {
        title: 'Is my data secure with your service?',
        content: 'Absolutely. We take data security very seriously and use industry-standard encryption to protect your documents. Your files are only stored temporarily while being processed and are deleted after you have downloaded your split PDFs.'
    },
    {
        title: 'Can I split PDFs that don’t have bookmarks?',
        content: 'Yes, you can. For PDFs without bookmarks, you’ll have the option to manually specify the pages where the document should be split. Our intuitive interface makes this process quick and easy.'
    },
    {
        title: 'What happens if the PDF splitting is unsuccessful?',
        content: 'In the rare event that your PDF cannot be split as expected, our customer support team is here to help. You can contact us through the support portal, and we will assist you in resolving the issue promptly.'
    },
    {
        title: 'Do you offer a trial period?',
        content: 'Yes, we offer a 7-day free trial period where you can test all the features of our Basic plan. This allows you to experience the ease and functionality of our service before committing to a subscription.'
    },
    {
        title: 'What payment methods do you accept?',
        content: 'We accept all major credit cards. Our payment processing is handled securely, ensuring your payment information is safe.'
    },
    {
        title: 'How can I cancel my subscription?',
        content: 'You can cancel your subscription at any time directly from your account settings. There are no cancellation fees, and you can continue to use the service until the end of your current billing cycle.'
    },
    {
        title: 'What kind of customer support do you offer?',
        content: 'We offer email support for all our users and priority support for our Standard and Premium plan subscribers. Our dedicated team is committed to ensuring you have the best experience with our service.'
    },
]

const toggleFaq = (index) => {
    selectedFaq.value = selectedFaq.value === index ? null : index;
}
</script>

<template>
    <div id="faq" class="py-8 sm:py-16 px-8">
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
