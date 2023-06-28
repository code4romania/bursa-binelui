<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('articles_title')" />

        <div class="mx-auto mb-10 max-w-7xl">
            <carousel v-if="query?.data?.length" class="w-full" :items-to-show="1" :autoplay="4000" :pauseAutoplayOnHover="true" :wrapAround="true" :transition="300">
                <slide v-for="(article, index) in query.data" :key="index" class="flex flex-col-reverse w-full px-9 lg:flex-row lg:items-start lg:justify-start">
                    <div class="w-full lg:w-6/12">

                        <div class="flex justify-start w-full mb-6">
                            <div class="inline-flex items-center justify-start px-3 py-1 text-base font-semibold rounded-full cursor-pointer text-primary-500 bg-primary-50 gap-x-1">
                                {{ article.category }}
                            </div>
                        </div>

                        <h1 v-if="article.title" class="text-6xl font-extrabold text-left text-gray-900">{{ article.title }}</h1>

                        <div class="flex items-center justify-start w-full mt-4 text-2xl font-bold text-cyan-900">
                            <p class="">{{ article.author }}&nbsp;|&nbsp;</p>
                            <p class="">{{ article.ong }}</p>
                        </div>

                        <div class="flex flex-col w-full gap-4 mt-10 sm:flex-row">
                            <Link
                                :href="route('article', article.id)"
                                class="rounded-md px-3.5 py-2.5 text-sm text-white font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 bg-primary-500"
                            >
                                {{ $t('read_article') }}
                            </Link>
                        </div>
                    </div>

                    <div class="relative items-center justify-center hidden w-full p-20 lg:w-6/12 sm:flex">

                        <div class="absolute bottom-0 right-0">
                            <SvgLoader class="shrink-0 fill-primary-500" name="dotted_square" />
                        </div>

                        <div class="relative flex items-center w-fit">
                            <img class="mx-auto rounded-md shadow" :src="article.image" alt="" />
                        </div>
                    </div>
                </slide>
            </carousel>

            <div class="grid w-full grid-cols-12 gap-12 mt-14 lg:px-9">
                <div class="col-span-8 ">

                    <div v-if="filter?.category" class="flex items-center mb-4 gap-x-4">
                        <h2 class="text-3xl font-bold text-cyan-900">{{ $t('other_articles') }}</h2>
                        <div class="inline-flex items-center px-3 py-1 text-base text-white rounded-full bg-primary-500 gap-x-1">
                            {{ filter.category }}
                        </div>
                    </div>

                    <div v-if="query?.data?.length" class="grid grid-cols-1 gap-6 mb-4 sm:grid-cols-2">
                        <div
                            v-for="(article, index) in query.data"
                            :key="article.id"
                            :class="[
                                0 === index ? 'md:col-span-2' : 'col-span-1',
                                'flex flex-col flex-1 rounded-lg shadow-md'
                            ]"
                        >
                            <Link
                                :href="route('article', article.id)"
                                :class="[
                                    'relative group-hover:opacity-75 '
                                ]"
                            >
                                <div>
                                    <img
                                        :src="article.image!=='' ?article.image: 'https://images.unsplash.com/photo-1508779544523-dd1b27685be3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80'"
                                        alt="imagine proiect"
                                        class="w-full rounded-t-lg"
                                    />

                                    <div class="absolute z-10 bottom-3 left-3">
                                        <div class="inline-flex items-center justify-start px-3 py-1 text-base font-semibold rounded-full shadow cursor-pointer text-primary-500 bg-primary-50 gap-x-1">
                                            {{ article.category }}
                                        </div>
                                    </div>
                                </div>
                            </Link>

                            <div class="h-full px-6 py-6 space-y-6">
                                <p class="text-sm text-gray-500">{{ article.author }}</p>
                                <div>
                                    <Link :href="route('article', article.id)" class="text-lg font-bold text-gray-900">{{ article.title }}</Link>
                                </div>
                                <div class="text-sm text-gray-500" v-html="article.content"></div>

                                <div class="flex items-center justify-between mt-auto text-sm">
                                    <p class="text-gray-500 ">{{ article.created_at }}</p>
                                    <Link
                                        :href="route('article', article.id)"
                                        class="flex items-center font-semibold text-primary-500 gap-x-2"
                                    >
                                        {{ $t('read_article') }}
                                        <SvgLoader name="arrow_right" class="shrink-0"/>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Pagination -->
                    <Pagination
                        v-if="query.links"
                        :currentPage="query.current_page"
                        :prev="query.prev_page_url"
                        :next="query.next_page_url"
                        :links="query.links"
                    />
                </div>

                <div class="col-span-12 lg:col-span-4">
                    <div>
                        <h2 class="mb-5 text-3xl font-bold text-cyan-900">{{ $t('other_categories') }}</h2>

                        <div class="flex flex-wrap items-center gap-x-3 gap-y-5">
                            <div
                                v-for="(category, index) in categories"
                                :key="index"
                                class="inline-flex items-center px-3 py-1 text-base font-semibold rounded-full cursor-pointer text-primary-500 bg-primary-50 gap-x-1"
                                @click="filterArticles(category)"
                            >
                                {{ category }}
                            </div>
                        </div>
                    </div>

                    <div class="w-full mt-10">
                        <h2 class="mb-5 text-3xl font-bold text-cyan-900">{{ $t('other_categories') }}</h2>
                        <div
                            v-for="(article, index) in query.data"
                            :key="index"
                            class="w-full p-6 mb-6 space-y-6 border-l-8 rounded shadow border-primary-500"
                        >
                            <div class="inline-flex items-center justify-start px-3 py-1 text-base font-semibold rounded-full cursor-pointer text-primary-500 bg-primary-50 gap-x-1">
                                {{ article.category }}
                            </div>

                            <div class="flex items-center justify-start w-full mt-4 text-sm text-gray-500">
                                <p class="">{{ article.author }}&nbsp;|&nbsp;</p>
                                <p class="">{{ article.ong }}</p>
                            </div>

                            <h3 class="text-lg font-bold text-gray-900">{{ article.title }}</h3>

                            <div class="flex items-center justify-between text-sm">
                                <p class="text-gray-500 ">{{ article.created_at }}</p>
                                <Link
                                    :href="route('article', article.id)"
                                    class="flex items-center font-semibold text-primary-500 gap-x-2"
                                >
                                    {{ $t('read_article') }}
                                    <SvgLoader name="arrow_right" class="shrink-0"/>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
/** Import from vue. */
import { ref } from 'vue';

/** Import from inertia. */
import { Head, Link, router } from '@inertiajs/vue3';

/** Import components. */
import PageLayout from '@/Layouts/PageLayout.vue';
import SvgLoader from '@/Components/SvgLoader.vue';
import Pagination from '@/Components/pagination/Pagination.vue';

/** Import plugins */
import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide } from 'vue3-carousel';

const props = defineProps({
    query: Object,
    categories: Array
});

const filter = ref({ category : null });

const filterArticles = (value) => {
    filter.value.category = value;

    router.visit(route('articles'), {
        method: 'get',
        data: filter.value,
        preserveState: true,
    });
};
</script>
