<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('my_profile')" />

        <div class="px-6 mx-auto my-10 space-y-10 lg:px-0 max-w-7xl">
            <div class="flex flex-col gap-6 md:gap-10 md:flex-row">
                <div class="w-full md:w-1/2">
                    <!-- Header -->
                    <header class="flex items-center gap-4">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500"
                        >
                            <SvgLoader
                                class="fill-primary-500 shrink-0"
                                name="brand_icon"
                            />
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            {{ $t("my_profile") }}
                        </h2>
                    </header>

                    <div
                        v-html="profile.description"
                        class="my-6 space-y-6 text-sm text-gray-500"
                    ></div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div
                    class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500"
                >
                    <SvgLoader
                        class="fill-primary-500 shrink-0"
                        name="brand_icon"
                    />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ $t("my_prizes") }}
                </h2>
            </div>

            <div v-if="badges.length" class="grid gap-12 md:grid-cols-2">
                <div
                    v-for="(badge, index) in badges"
                    :key="index"
                    class="grid gap-6 sm:grid-cols-3"
                >
                    <div class="w-36 md:w-auto">
                        <img
                            class="object-contain w-full"
                            :src="badge.image"
                            :alt="badge.name"
                        />
                    </div>
                    <div
                        class="space-y-4 text-gray-500 lg:space-y-6 sm:col-span-2"
                    >
                        <h3 class="text-lg font-bold" v-text="badge.title" />
                        <p class="text-sm" v-text="badge.description" />
                    </div>
                </div>
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { Head, Link } from "@inertiajs/vue3";
    import PageLayout from "@/Layouts/PageLayout.vue";
    import SvgLoader from "@/Components/SvgLoader.vue";

    const props = defineProps({
        profile: Object,
        badges: Array,
    });
</script>
