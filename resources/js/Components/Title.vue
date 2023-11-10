<template>
    <header class="flex items-center gap-4">
        <div class="flex w-10 h-10 p-2 text-white rounded-lg bg-primary-500 shrink-0">
            <component :is="icon" />
        </div>

        <h1 class="text-2xl font-bold leading-none text-gray-900 md:text-3xl" v-text="title" />

        <Head :title="title" />
    </header>
</template>

<script setup>
    import { ViewListIcon } from '@heroicons/vue/solid';
    import Head from '@/Components/Head.vue';

    const props = defineProps({
        title: {
            type: String,
            required: null,
        },
        icon: {
            type: Function,
            default: ViewListIcon,
        },
    });
</script>

