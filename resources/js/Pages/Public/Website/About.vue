<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('thank_you')" />

        <div class="p-9 mx-auto max-w-7xl mt-4 mb-10">

        </div>
    </PageLayout>
</template>

<script setup>
    /** Remove this import after backend connection. */
    import project from '@/local_json/project.js';

    /** Import from inertia. */
    import { Head, Link } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
</script>
