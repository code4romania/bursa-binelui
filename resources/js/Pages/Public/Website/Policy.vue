<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('thank_you')" />
        <div class="mx-auto mt-4 mb-10 p-9 max-w-7xl"></div>
    </PageLayout>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import Head from '@/Components/Head.vue';

    import PageLayout from '@/Layouts/PageLayout.vue';
</script>
