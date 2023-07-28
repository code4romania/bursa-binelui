<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('my_profile')" />

        <div class="px-6 mx-auto my-10 space-y-10 lg:px-0 max-w-7xl">

            <div class="flex flex-col gap-6 md:gap-10 md:flex-row">
                <div class="w-full md:w-1/2">
                    <!-- Header -->
                    <header class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                            <SvgLoader class="fill-primary-500 shrink-0" name="brand_icon" />
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $t('my_profile') }}</h2>
                    </header>

                    <div
                        v-html="profile.description"
                        class="my-6 space-y-6 text-sm text-gray-500"
                    ></div>
                </div>

                <div class="w-full lg:w-1/2 lg:px-10">
                    <div class="bg-white shadow-lg">


                        <div class="p-8 space-y-8">
                            <div class="inline-flex items-center justify-start px-3 py-1 text-base font-semibold rounded-full cursor-pointer text-primary-500 bg-primary-50">
                                TOP
                            </div>
                            <h3 class="text-6xl font-bold leading-6 text-gray-900">{{ profile.donations_place }}</h3>
                            <p class="text-lg text-gray-500">{{ $t('donations_place_1') }} {{ profile.donations_place }} {{ $t('donations_place_2') }}</p>
                        </div>

                        <div class="px-10 py-8 space-y-6 bg-gray-50">

                            <div v-for="info in profile.donations_status" class="flex items-center justify-start gap-x-4">
                                <SvgLoader class="shrink-0 fill-gray-50" name="check" />
                                <p class="text-base font-normal text-gray-500">{{ info }}</p>
                            </div>

                            <div class="w-full">
                                <Link
                                    :href="route('donor.donations')"
                                    class="rounded-md block text-center px-3.5 py-2.5 text-sm text-white font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 bg-primary-500"
                                >
                                    {{ $t('see_all_donations') }}
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                    <SvgLoader class="fill-primary-500 shrink-0" name="brand_icon" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $t('my_prizes') }}</h2>
            </div>

            <div v-if="badges.length" class="grid grid-cols-12 gap-8">
                <div
                    v-for="(badge, index) in badges"
                    :key="index"
                    class="flex items-center col-span-12 gap-6 md:col-span-6"
                >
                    <img class="w-36 md:w-auto" :src="`/images/badges/${badge.name}.png`" :alt="`${badge.name}`">
                    <div class="pr-4 space-y-4 text-gray-500 lg:space-y-6">
                        <h3 class="text-lg font-bold">{{ $t(`${badge.title}`) }}</h3>
                        <p class="text-sm">{{ $t(`${badge.description}`) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
/** Import from inertia. */
import { Head, Link } from '@inertiajs/vue3';
import PageLayout from '@/Layouts/PageLayout.vue';
import SvgLoader from '@/Components/SvgLoader.vue';

const props = defineProps({
    profile: Object,
    badges: Array
});
</script>
