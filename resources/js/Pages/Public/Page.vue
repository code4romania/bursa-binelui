<template>
    <PageLayout>
        <Head :title="page.title" :description="page.description" />

        <div class="container my-8 sm:my-14 lg:my-20">
            <div class="prose-sm prose max-w-none sm:prose-lg">
                <h1 class="font-extrabold text-gray-900" v-text="page.title" />

                <div v-html="page.content" />
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
    import Head from '@/Components/Head.vue';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';

    const props = defineProps({
        page: Object,
    });
</script>
