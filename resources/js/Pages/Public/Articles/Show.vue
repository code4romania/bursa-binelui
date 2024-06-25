<template>
    <PageLayout>
        <Head :title="resource.title" :description="resource.description" :image="resource.cover" />

        <figure class="container">
            <div class="aspect-w-2 aspect-h-1">
                <img class="object-cover" :src="resource.cover" alt="" />
            </div>
        </figure>

        <div class="container">
            <div
                class="inline-flex items-center justify-start px-3 py-1 mt-10 text-base font-semibold rounded-full cursor-pointer text-primary-500 bg-primary-50 gap-x-1"
            >
                {{ resource.category }}
            </div>

            <div class="prose-sm prose max-w-none sm:prose-lg xl:prose-xl">
                <h1 class="font-extrabold text-gray-900" v-text="resource.title" />

                <div class="">
                    <h2 class="!text-3xl text-primary-900">{{ $t('share_page') }}</h2>
                    <SharePage class="mt-4" :pageRoute="route('articles.show', resource.id)" />
                </div>

                <div v-html="resource.content" />
            </div>
        </div>

        <div class="w-full bg-gray-100">
            <div class="mx-auto max-w-7xl">
                <Gallery :images="resource.swipe_gallery" class="mt-10" />

                <div class="flex items-center justify-between pt-6 pb-20">
                    <div class="flex items-center justify-start w-full text-gray-500 f">
                        <p>{{ resource.author }}</p>
                    </div>
                    <p class="text-gray-500">{{ resource.created_at }}</p>
                </div>
            </div>
        </div>

        <div class="relative mb-10 overflow-hidden pb-9">
            <div class="pt-12 pb-20 bg-primary-500 px-9 lg:px-0">
                <div class="flex items-center gap-4 mx-auto max-w-7xl">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-100">
                        <SpeakerphoneIcon class="w-5 h-5 fill-primary-100 stroke-white shrink-0" />
                    </div>
                    <h3 class="text-2xl font-bold text-white">{{ $t('related_articles') }}</h3>
                </div>
            </div>

            <div class="relative bg-white">
                <ul
                    class="grid grid-cols-1 gap-8 mx-auto -mt-12 lg:mt-0 max-w-7xl sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3"
                >
                    <ArticleCard
                        :article="article"
                        class="relative z-50 lg:-mt-12"
                        v-for="article in related.data"
                        :key="article.id"
                    />
                </ul>
                <LargeSquarePattern class="absolute top-0 right-0 z-10 hidden lg:block fill-primary-200" />
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
    import ArticleCard from '@/Components/cards/ArticleCard.vue';
    import Head from '@/Components/Head.vue';
    import LargeSquarePattern from '@/Components/patterns/LargeSquarePattern.vue';
    import PageLayout from '@/Layouts/PageLayout.vue';
    import SharePage from '@/Components/SharePage.vue';
    import Gallery from '@/Components/Gallery.vue';
    import { SpeakerphoneIcon } from '@heroicons/vue/outline';

    defineProps({
        resource: {
            type: Object,
            required: true,
        },
        related: {
            type: Object,
            default: () => ({}),
        },
    });
</script>
