<template>
    <Head :title="title">
        <meta property="og:title" :content="title" />

        <template v-if="description">
            <meta property="og:description" :content="description" />
            <meta name="description" :content="description" />
        </template>

        <meta v-if="image" property="og:image" :content="image" />

        <slot />
    </Head>
</template>


<script setup>
    /** Import from inertia. */
    import { Head } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';

    const props = defineProps({
        title: {
            type: String,
            required: true,
        },
        description: {
            type: String,
            default: null,
        },
        image: {
            type: String,
            default: null,
        },
    });
</script>
