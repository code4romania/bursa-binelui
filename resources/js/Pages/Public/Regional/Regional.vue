<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('regional_title')" />

        <!-- Header -->
        <div
            class="flex flex-col-reverse w-full gap-10 mx-auto overflow-hidden lg:my-10 lg:flex-row lg:max-w-7xl sm:mt-0 px-9"
        >
            <div class="relative flex flex-col w-full lg:w-6/12">
                <h1
                    class="relative py-6 text-3xl font-extrabold text-gray-900 lg:py-12 lg:text-6xl"
                    v-text="$t('regional_title')"
                />

                <div class="flex flex-col w-full gap-4 mb-6 lg:mb-0 sm:flex-row">
                    <Link
                        v-text="$t('regional.project.page.rules_page')"
                        :href="route('regional.rules', edition.page_rules)"
                        class="rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:opacity-50 disabled:cursor-default text-gray-900 bg-white ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                    />
                    <Link
                        v-text="$t('regional.project.page.registration_project')"
                        :href="route('dashboard.projects.gala.index')"
                        class="flex items-center justify-center gap-2 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:opacity-50 disabled:cursor-default bg-primary-500 hover:bg-primary-400 text-white focus-visible:outline-primary-500"
                    />
                </div>

                <LargeSquarePattern class="absolute hidden md:block -top-24 -left-32 fill-primary-100" />
            </div>

            <div class="relative items-center justify-center w-full lg:px-20 lg:pb-9 lg:w-6/12 sm:flex">
                <LargeSquarePattern class="absolute bottom-0 right-0 hidden md:block fill-primary-500" />

                <div class="relative flex items-center bg-white rounded shadow w-fit">
                    <img class="mx-auto rounded-lg" src="/images/auth_image.jpg" alt="" />

                    <div
                        class="absolute flex items-center justify-center w-32 h-32 rounded-lg bg-gray-50 -bottom-10 -left-10"
                    ></div>
                </div>
            </div>
        </div>

        <div class="mx-auto mb-10 max-w-7xl p-9 md:flex-row">
            <h3 class="mb-6 text-3xl font-bold text-primary-900" v-text="$t('about_regional')" />
            <div class="text-base font-normal text-gray-500" v-html="$t('regional.project.page.about')"></div>
        </div>

        <div class="relative mb-10 overflow-hidden pb-9">
            <div class="pt-12 pb-20 bg-primary-500 px-9 lg:px-0">
                <div class="flex items-center gap-4 mx-auto max-w-7xl">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-100">
                        <SpeakerphoneIcon class="w-5 h-5 fill-primary-100 stroke-white shrink-0" />
                    </div>
                    <h3 class="text-2xl font-bold text-white" v-text="$t('regional.project.page.calendar')"></h3>
                </div>
            </div>

            <div class="container">
                <div
                    class="grid grid-cols-9 px-20 py-8 mt-4 mb-8 rounded-lg shadow bg-gray-50"
                    v-for="item in edition.gales"
                >
                    <div class="col-span-6">
                        <h3 class="text-2xl font-bold text-gray-800 divide-x divide-gray-200" v-text="item.title" />
                        <div class="flex mt-2">
                            <Icon class="w-5 h-5 shrink-0 text-primary-900" name="location" />
                            <p v-text="$t('county_available_for_participation')" class="accent-gray-500 text-md" />
                            <p v-text="item.counties" />
                        </div>
                    </div>

                    <div class="content-center col-span-3 text-center border-l-2" v-if="item.registration_start_soon">
                        <h3
                            v-text="$t('regional.project.page.registration_start_soon')"
                            class="mb-4 accent-gray-500 text-md"
                        />
                        <p v-text="item.start_sign_up" class="text-2xl"></p>

                        <p>
                            {{ $t('regional.project.page.see_rules') }}
                            <Link
                                class="text-primary-500 hover:underline"
                                :href="route('regional.rules', edition.page_rules)"
                                v-text="$t('regional.project.page.rules_page')"
                            />
                        </p>
                    </div>

                    <div class="content-center col-span-3 text-center border-l-2" v-if="item.registration_is_open">
                        <h3
                            v-text="$t('regional.project.page.registration_is_open')"
                            class="mb-4 accent-gray-500 text-md"
                        />
                        <p v-text="item.register_period" class="text-2xl"></p>

                        <p>
                            {{ $t('regional.project.page.see_rules') }}
                            <Link
                                class="text-primary-500 hover:underline"
                                :href="route('regional.rules', edition.page_rules)"
                                v-text="$t('regional.project.page.rules_page')"
                            />
                        </p>
                    </div>

                    <div class="content-center col-span-3 text-center border-l-2" v-if="item.registration_ended">
                        <h3
                            v-text="$t('regional.project.page.registration_ended')"
                            class="mb-4 accent-gray-500 text-md"
                        />
                        <Link
                            :href="route('regional.galas.show', item.id)"
                            class="flex items-center justify-center gap-2 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:opacity-50 disabled:cursor-default bg-primary-500 hover:bg-primary-400 text-white focus-visible:outline-primary-500"
                        >
                            {{ $t('regional.project.page.see_projects') }}
                            <ChevronRightIcon class="w-5 h-5 fill-white stroke-white shrink-0" />
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="container grid grid-cols-6 mt-4">
            <div class="col-span-2 p-8 mx-auto">
                <h3 class="text-2xl font-bold text-gray-800" v-text="$t('regional.project.page.faqs')" />
                <p class="my-4" v-html="$t('regional.project.page.faqs_description')" />
            </div>
            <div class="col-span-4 p-8">
                <div v-for="item in edition.faqs" :key="item.id">
                    <h3 class="text-xl font-bold text-gray-800" v-text="item.question" />
                    <p class="my-4" v-text="item.answer" />
                </div>
            </div>
        </div>

        <div class="relative mb-10 overflow-hidden pb-9">
            <div class="pt-12 pb-20 bg-primary-500 px-9 lg:px-0">
                <div class="flex items-center gap-4 mx-auto max-w-7xl">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-100">
                        <SpeakerphoneIcon class="w-5 h-5 fill-primary-100 stroke-white shrink-0" />
                    </div>
                    <h3 class="text-2xl font-bold text-white" v-text="$t('regional.project.page.articles')"></h3>
                </div>
            </div>

            <div class="container -mt-8">
                <div class="grid grid-cols-3 gap-6">
                    <ArticleCard v-for="(article, index) in articles.data" :key="article.id" :article="article" />
                </div>
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
/** Import from vue */
import { onMounted, ref } from 'vue';
import route from '@/Helpers/useRoute';

/** Import from inertia. */
import { Link } from '@inertiajs/vue3';
import Head from '@/Components/Head.vue';

/** Import components. */
import PageLayout from '@/Layouts/PageLayout.vue';
import { ChevronRightIcon, SpeakerphoneIcon } from '@heroicons/vue/outline';

import LargeSquarePattern from '@/Components/patterns/LargeSquarePattern.vue';
import Icon from '@/Components/Icon.vue';
import ArticleCard from '@/Components/cards/ArticleCard.vue';

const props = defineProps({
    edition: {
        type: Object,
        default: null,
    },
    articles: {
        type: Array,
        default: null,
    },
});
</script>
