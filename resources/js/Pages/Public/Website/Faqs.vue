<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('faqs_title')" />

        <div class="mx-auto mt-4 mb-10 space-y-6 p-9 max-w-7xl">
            <h1 v-if="faqs?.title" class="text-2xl font-bold text-cyan-900">{{ faqs.title }}</h1>
            <div v-if="faqs?.content" v-html="faqs.content" class="space-y-4 text-sm text-gray-500"></div>
            <Faqs v-if="faqs?.faqs?.length" :data="faqs.faqs" />
        </div>
    </PageLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { Head } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Faqs from '@/Components/faqs/Faqs.vue';

    const props = defineProps({
        faqs: Object
    })
</script>

