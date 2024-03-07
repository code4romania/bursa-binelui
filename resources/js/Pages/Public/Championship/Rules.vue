<template>
    <PageLayout>
        <Head :title="$t('regional_rules_title')" />

        <div class="w-full mx-auto space-y-9 lg:max-w-7xl p-9">
            <h1 class="text-6xl font-bold text-primary-900">{{ content?.title }}</h1>
            <h2 class="text-lg font-semibold text-gray-700">{{ content?.subtitle }}</h2>
            <div v-html="content?.body"></div>
        </div>
    </PageLayout>
</template>

<script setup>
    import Head from '@/Components/Head.vue';
    import PageLayout from '@/Layouts/PageLayout.vue';

    const props = defineProps({
        content: Object,
    });
</script>
