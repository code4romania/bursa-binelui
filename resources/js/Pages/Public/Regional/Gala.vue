<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('bb_regional_title')" />

        <!-- Header -->
        <div class="flex flex-col-reverse w-full gap-10 mx-auto lg:my-10 lg:flex-row lg:max-w-7xl sm:mt-0 px-9">
            <div class="relative flex flex-col w-full lg:w-6/12">
                <h1
                    class="relative z-50 py-6 text-3xl font-extrabold text-gray-900 lg:py-12 lg:text-6xl"
                    v-text="gala.title"
                />
                <div class="mt-2 flex">
                    <Icon class="w-5 h-5 shrink-0 text-primary-900" name="location" />
                    <p v-text="$t('county_available_for_participation')" class="accent-gray-500 text-md" />
                    <p v-text="gala.counties" />
                </div>
            </div>

            <div class="relative items-center justify-center w-full lg:px-20 lg:pb-9 lg:w-6/12 sm:flex">
                <div class="relative flex items-center bg-white rounded shadow w-fit">
                    <img class="mx-auto rounded-lg" :src="gala.preview" alt="" />
                </div>
            </div>
        </div>

        <!-- Countdown -->
        <div class="bg-primary-500 w-full">
            <div class="flex flex-col flex-wrap items-center justify-center max-w-5xl gap-6 mx-auto mb-10 p-9">
                <h3 class="text-xl font-bold text-gray-300" v-text="$t('regional.project.gala.registration_ended')" />
                <h3 class="text-2xl font-bold text-white" v-text="gala.start_gale" />
            </div>
        </div>
        <div class="mx-auto mb-10 p-9">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-8 h-8 p-1 rounded-lg bg-primary-500"></div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $t('participants') }}</h2>
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
import Head from '@/Components/Head.vue';

import PageLayout from '@/Layouts/PageLayout.vue';
import Icon from '@/Components/Icon.vue';

const props = defineProps({
    gala: {
        type: Object,
        default: () => ({}),
    },
});
</script>
