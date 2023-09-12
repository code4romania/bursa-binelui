
<template>
    <PageLayout>
        <main class="container relative grid min-h-full px-6 py-24 -mb-32 place-items-center sm:py-32 lg:px-8">
            <div class="text-center">
                <p class="text-base font-extrabold text-primary-600" v-text="status" />
                <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl" v-text="title" />
                <p class="mt-6 text-base leading-7 text-gray-600" v-text="message" />
                <div class="flex flex-wrap items-center justify-center gap-6 mt-10">
                    <Link
                        href="/"
                        class="rounded-md bg-primary-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-500 flex gap-2 items-center"
                    >
                        <ArrowNarrowLeftIcon aria-hidden="true" class="w-4 h-4 -ml-1" />
                        <span v-text="$t('back_home')" />
                    </Link>
                </div>
                <SmallSquarePattern class="absolute top-0 hidden shrink-0 fill-primary-300 left-16 md:block" />

                <LargeSquarePattern class="absolute hidden lg:block -bottom-32 -right-32 fill-primary-300" />
            </div>
        </main>
    </PageLayout>
</template>

<script setup>
    import PageLayout from '@/Layouts/PageLayout.vue';
    import { ArrowNarrowLeftIcon } from '@heroicons/vue/solid';
    import SmallSquarePattern from '@/Components/patterns/SmallSquarePattern.vue';
    import LargeSquarePattern from '@/Components/patterns/LargeSquarePattern.vue';

    const props = defineProps({
        status: Number,
        title: String,
        message: String,
    });
</script>
