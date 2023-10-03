<template>
    <article class="relative flex flex-col col-span-1 bg-white rounded-lg drop-shadow-lg">
        <div class="relative">
            <figure class="aspect-w-2 aspect-h-1">
                <img class="object-cover" :src="article.cover" alt="" />
            </figure>

            <ArticleCategory
                v-if="article.category !== null"
                :category="article.category"
                class="absolute z-10 left-4 bottom-4 drop-shadow"
            />
        </div>

        <div class="p-6">
            <div v-if="article.author" class="flex mb-6 text-sm text-gray-500" v-text="article.author" />

            <h3 class="mb-3 text-xl font-bold text-gray-900 line-clamp-2" v-text="article.title" />

            <div class="text-gray-500 line-clamp-4" v-html="article.description" />

            <div class="flex items-center justify-between mt-6">
                <time class="text-sm text-gray-500" v-text="article.date" />

                <Link
                    :href="route('articles.show', article)"
                    class="flex items-center text-sm font-semibold gap-x-1 text-primary-500 hover:underline"
                >
                    <span class="absolute inset-0" />

                    <span v-text="$t('read_article')" />
                    <ArrowNarrowRightIcon class="w-4 h-4 shrink-0" />
                </Link>
            </div>
        </div>
    </article>
</template>

<script setup>
    import ArticleCategory from '@/Components/ArticleCategory.vue';
    import { ArrowNarrowRightIcon } from '@heroicons/vue/solid';

    defineProps({
        article: {
            type: Object,
            required: true,
        },
    });
</script>
