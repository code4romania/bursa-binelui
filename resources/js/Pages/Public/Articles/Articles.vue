<template>
    <PageLayout>
        <Head title="Articole" />

        <ClientOnly>
            <Carousel
                class="w-full"
                :items-to-show="1"
                :autoplay="40000"
                :pauseAutoplayOnHover="true"
                :wrapAround="true"
                :transition="300"
            >
                <Slide v-for="article in collection.data" :key="article.id" class="">
                    <div class="container flex flex-col-reverse items-start justify-start lg:items-center lg:flex-row">
                        <div class="w-full text-left lg:w-1/2">
                            <div class="flex justify-start w-full pt-4 mb-6">
                                <ArticleCategory v-if="article.category !== null" :category="article.category" />
                            </div>

                            <h1
                                class="text-3xl font-extrabold text-gray-900 md:text-4xl line-clamp-3"
                                v-text="article.title"
                            />

                            <div
                                class="w-full mt-5 text-2xl font-bold text-primary-900"
                                v-if="article.author"
                                v-text="article.author"
                            />

                            <div class="flex flex-col w-full gap-4 mt-10 sm:flex-row">
                                <Link
                                    :href="route('articles.show', article.slug)"
                                    class="rounded-md px-3.5 py-2.5 text-sm text-white font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 bg-primary-500"
                                >
                                    {{ $t('read_article') }}
                                </Link>
                            </div>
                        </div>

                        <div class="relative items-center justify-end hidden w-full translate-x-20 lg:w-1/2 sm:flex">
                            <LargeSquarePattern class="absolute bottom-0 right-0 fill-primary-500" />

                            <div class="relative flex items-center p-20 w-fit">
                                <img class="mx-auto rounded-md shadow" :src="article.cover" alt="" />
                            </div>
                        </div>
                    </div>
                </Slide>
            </Carousel>
        </ClientOnly>

        <section class="container grid grid-cols-12 gap-12">
            <div class="grid col-span-8 gap-10 mt-2">
                <header v-if="!category">
                    <Head :title="$t('articles.index')" />
                    <h1 v-text="$t('articles.index')" class="text-3xl font-bold text-primary-900" />
                </header>
                <header v-else>
                    <Head :title="$t('articles.category', { category: category.name })" />
                    <h1
                        v-text="$t('articles.category', { category: category.name })"
                        class="text-3xl font-bold text-primary-900"
                    />
                </header>

                <div class="grid gap-6 sm:grid-cols-2">
                    <ArticleCard
                        v-for="(article, index) in collection.data"
                        :key="article.id"
                        :article="article"
                        :class="{
                            'sm:col-span-2': index === 0,
                        }"
                    />
                </div>

                <Pagination
                    v-if="collection.links && collection.links.first !== collection.links.last"
                    :resource="collection"
                />
            </div>

            <aside class="col-span-12 lg:col-span-4">
                <div>
                    <h2 class="mb-5 text-3xl font-bold text-primary-900">{{ $t('categories') }}</h2>

                    <div class="flex flex-wrap gap-2">
                        <ArticleCategory v-for="(category, index) in categories" :key="index" :category="category" />
                    </div>
                </div>

                <div class="w-full mt-10">
                    <h2 class="mb-5 text-3xl font-bold text-primary-900">{{ $t('other_articles_label') }}</h2>
                    <div
                        v-for="(article, index) in topArticles.data"
                        :key="index"
                        class="w-full p-6 mb-6 space-y-6 border-l-8 rounded shadow border-primary-500"
                    >
                        <div
                            class="inline-flex items-center justify-start px-3 py-1 text-base font-semibold rounded-full cursor-pointer text-primary-500 bg-primary-50 gap-x-1"
                        >
                            {{ article.category.name }}
                        </div>

                        <div class="flex items-center justify-start w-full mt-4 text-sm text-gray-500">
                            <p class="">{{ article.author }}</p>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900">{{ article.title }}</h3>

                        <div class="flex items-center justify-between text-sm">
                            <p class="text-gray-500">{{ article.created_at }}</p>
                            <Link
                                :href="route('articles.show', article.slug)"
                                class="flex items-center font-semibold text-primary-500 gap-x-2"
                            >
                                {{ $t('read_article') }}

                                <ArrowRightIcon class="w-5 h-5 shrink-0" />
                            </Link>
                        </div>
                    </div>
                </div>
            </aside>
        </section>
    </PageLayout>
</template>

<script setup>
import PageLayout from '@/Layouts/PageLayout.vue';
import Head from '@/Components/Head.vue';
import Pagination from '@/Components/pagination/Pagination.vue';
import ArticleCard from '@/Components/cards/ArticleCard.vue';
import ArticleCategory from '@/Components/ArticleCategory.vue';
import ClientOnly from '@/Components/ClientOnly.vue';

import LargeSquarePattern from '@/Components/patterns/LargeSquarePattern.vue';

import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide } from 'vue3-carousel';
import { ArrowRightIcon } from '@heroicons/vue/solid';

const props = defineProps({
    collection: {
        type: Object,
        required: true,
    },
    topArticles: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        default: () => [],
    },
    category: {
        type: Object,
        default: null,
    },
});

const filterArticles = (value) => {};
</script>
