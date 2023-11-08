<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('faqs_title')" />

        <div class="mx-auto mt-4 mb-10 space-y-6 p-9 max-w-7xl">
            <h1 v-if="faqs?.title" class="text-3xl font-bold text-cyan-900">{{ faqs.title }}</h1>
            <div v-if="faqs?.content" v-html="faqs.content" class="space-y-4 text-base text-gray-500"></div>

            <div class="relative bg-white z-101">
                <Faqs v-if="faqs?.faqs?.length" :data="faqs.faqs" />
            </div>

            <div class="mt-12">
                <p class="text-sm text-gray-500">{{ $t('need_help') }}</p>

                <Link
                    :href="route('contact')"
                    class="inline-flex items-center justify-center gap-4 mt-4 rounded-md bg-primary-500 px-3.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-400 py-2.5"
                >
                    {{ $t('contact_us') }}
                </Link>
            </div>

            <LargeSquarePattern class="absolute left-0 z-0 hidden bottom-60 md:block fill-gray-200" />
            <LargeSquarePattern class="absolute right-0 z-0 hidden top-32 md:block fill-gray-200" />
        </div>
    </PageLayout>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import Head from '@/Components/Head.vue';
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Faqs from '@/Components/faqs/Faqs.vue';
    import Icon from '@/Components/Icon.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';

    import LargeSquarePattern from '@/Components/patterns/LargeSquarePattern.vue';

    const props = defineProps({
        faqs: Object,
    });
</script>

