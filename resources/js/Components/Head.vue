<template>
    <Head>
        <title v-if="title">{{ title }} - {{ $page.props.appName }}</title>
        <title v-else>{{ $page.props.appName }}</title>

        <meta property="og:title" :content="title" />
        <meta property="og:site_name" :content="$page.props.appName" />

        <template v-if="description">
            <meta property="og:description" :content="stripHTMLTags(description)" />
            <meta name="description" :content="stripHTMLTags(description)" />
        </template>

        <meta v-if="image" property="og:image" :content="image" />

        <meta name="twitter:card" content="summary_large_image" />

        <slot />
    </Head>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    title: {
        type: String,
        default: null,
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

const stripHTMLTags = (str) => str.replace(/<[^>]*>/g, '');
</script>
