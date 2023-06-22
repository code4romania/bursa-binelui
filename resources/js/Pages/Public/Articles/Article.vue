<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('thank_you')" />

        <div class="mx-auto mb-10 max-w-7xl">
            <div class="aspect-w-16 aspect-h-9">
                <img
                    :src="article.image!=='' ?article.image: 'https://images.unsplash.com/photo-1508779544523-dd1b27685be3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80'"
                    alt="imagine proiect"
                    class="object-cover w-full h-full"
                />
            </div>

            <div class="inline-flex items-center justify-start px-3 py-1 mt-10 text-base font-semibold rounded-full cursor-pointer text-turqoise-500 bg-turqoise-50 gap-x-1">
                {{ article.category }}
            </div>

            <h1 v-if="article.title" class="mt-6 text-6xl font-extrabold text-left text-gray-900">{{ article.title }}</h1>

            <div class="mt-6">
                <h2 class="text-2xl font-bold text-cyan-900">{{ $t('share_article') }}</h2>
                <SharePage
                    class="mt-4"
                    :id="article.id"
                    pageRoute="article"
                />
            </div>

            <div id="article" class="mt-6 text-sm text-gray-500" v-html="article.content"></div>
        </div>

        <div class="w-full bg-gray-100">
            <div class="mx-auto max-w-7xl">
                <Gallery
                    v-if="gallery.length"
                    :gallery="gallery"
                />
                <div class="flex items-center justify-between pt-6 pb-10 border-t border-gray-300">
                    <div class="flex items-center justify-start w-full text-gray-500 f">
                        <p>{{ article.author }}&nbsp;|&nbsp;</p>
                        <p>{{ article.ong }}</p>
                    </div>
                    <p class="text-gray-500">{{ article.created_at }}</p>
                </div>
            </div>
        </div>

        <div class="relative mb-10 overflow-hidden pb-9">

            <div class="pt-12 pb-20 bg-turqoise-500 px-9 lg:px-0">
                <div class="flex items-center gap-4 mx-auto max-w-7xl">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-turqoise-100">
                        <SvgLoader class="shrink-0 stroke-white fill-turqoise-100" name="sound" />
                    </div>
                    <h3 class="text-2xl font-bold text-white">{{ $t('related_articles') }}</h3>
                </div>
            </div>

            <div class="bg-white px-9">
                <ul role="list" class="grid grid-cols-1 gap-8 mx-auto -mt-12 lg:mt-0 max-w-7xl sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                    <ArticleCard :data="article" class="relative z-50 lg:-mt-12" />
                    <ArticleCard :data="article" class="relative z-50 lg:-mt-12" />
                    <ArticleCard :data="article" class="relative z-50 lg:-mt-12" />
                </ul>
            </div>

            <div class="absolute top-0 right-0 z-10 hidden lg:block">
                <SvgLoader class="shrink-0" name="squer_half_color" />
            </div>
        </div>
    </PageLayout>
</template>

<script setup>

/** Import from inertia. */
import { Head } from '@inertiajs/vue3';

/** Import components. */
import PageLayout from '@/Layouts/PageLayout.vue';
import SvgLoader from '@/Components/SvgLoader.vue';
import ArticleCard from '@/Components/cards/ArticleCard.vue';
import Gallery from '@/Components/gallery/Gallery.vue';
import SharePage from '@/Components/SharePage.vue';

const props = defineProps({
    article: Object,
    gallery: Array
});
</script>
