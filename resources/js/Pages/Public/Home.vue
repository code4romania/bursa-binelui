<template>
    <PageLayout>
        <Head />

        <!-- Header -->
        <header class="container grid items-center lg:gap-10 xl:gap-20 lg:grid-cols-2">
            <div class="py-12">
                <!-- Title -->
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 md:text-5xl lg:text-6xl">
                    <span class="inline-block" v-text="$t('home_title_1')" />
                    <span class="inline-block text-primary-500" v-text="$t('home_title_2')" />
                </h1>

                <!-- Links -->
                <div class="relative flex flex-wrap items-center gap-6 pb-10 my-10">
                    <Link
                        :href="route('projects.index')"
                        class="bg-primary-500 text-center w-full md:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                    >
                        {{ $t('donate_to_a_project') }}
                    </Link>

                    <Link
                        :href="route('evolution')"
                        class="rounded-md w-full md:w-auto bg-white text-center px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 py-2.5"
                    >
                        {{ $t('see_evolution') }}
                    </Link>

                    <SmallSquarePattern class="absolute top-0 hidden shrink-0 fill-primary-300 -left-16 md:block" />
                </div>

                <!-- Info texts -->
                <div class="flex flex-wrap items-center gap-16">
                    <div>
                        <h3 class="text-4xl font-bold text-gray-900 lg:text-6xl" v-text="projects_count" />
                        <p class="text-xl text-gray-900" v-text="$t('projects')" />
                    </div>
                    <div>
                        <h3 class="text-4xl font-bold text-gray-900 lg:text-6xl" v-text="organizations_count" />
                        <p class="text-xl text-gray-900" v-text="$t('organizations')" />
                    </div>
                </div>
            </div>

            <HeroPattern class="hidden lg:block" />
        </header>

        <div class="container">
            <div class="relative flow-root bg-white rounded shadow-md">
                <SmallSquarePattern class="absolute hidden lg:block -left-20 bottom-10 fill-primary-300" />
                <LargeSquarePattern class="absolute hidden lg:block -bottom-32 -right-32 fill-primary-300" />

                <div class="relative mx-auto my-10 lg:max-w-5xl">
                    <div class="flex flex-col items-center w-full mb-4 md:flex-row">
                        <div
                            class="relative flex-1 p-6 border border-gray-300 skew-x-[29deg] origin-top-left overflow-hidden"
                        >
                            <a
                                href="https://code4.ro/civic-tech-911"
                                target="_blank"
                                class="flex items-center justify-center gap-x-2 -skew-x-[29deg]"
                            >
                                <img class="h-10" src="/images/civic_tech.png" alt="Civic Tech 911" />
                            </a>
                        </div>
                        <a
                            href="https://code4.ro/ro"
                            target="_blank"
                            class="relative flex items-center justify-center flex-1 p-6 bg-white border border-gray-300 gap-x-2"
                        >
                            <p>un program</p>
                            <Icon name="code4romania" class="w-20 h-6 sm:h-8 md:h-10 shrink-0 sm:w-28 md:w-36" />
                        </a>
                    </div>

                    <div class="inline-flex flex-col">
                        <h3 class="inline px-6 py-2 text-2xl font-bold text-white bg-red-500 w-fit">
                            ONG-URILE DE PE BURSA BINELUI
                        </h3>
                        <h3 class="inline px-6 py-2 text-xl font-bold text-white w-fit bg-primary-500">
                            Se pot programa la CiviTech 911. Afla cum aici...
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <section v-if="projects">
            <div class="container flex flex-wrap justify-between gap-6 lg:items-center">
                <h1
                    class="w-full text-4xl font-extrabold leading-6 tracking-tight text-red-500 lg:text-5xl xl:text-6xl lg:w-auto"
                    v-text="$t('donate_for_good')"
                />

                <div class="lg:flex-1">
                    <Link
                        :href="route('projects.index')"
                        class="w-full inline-block font-semibold leading-6 text-center text-white bg-red-500 rounded-md shadow-sm lg:px-6 lg:py-4 lg:text-lg sm:w-auto hover:bg-red-400 focus-visible:outline-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 px-3.5 py-2.5 text-sm"
                    >
                        {{ $t('find_projects') }}
                    </Link>
                </div>

                <div class="flex items-center gap-6">
                    <button
                        type="button"
                        @click="projects_carousel.prev()"
                        class="flex items-center justify-center w-10 h-10 p-2 bg-white rounded-lg shadow-md cursor-pointer shrink-0"
                    >
                        <SvgLoader class="shrink-0 fill-gray-700" name="chevron_left" />
                    </button>

                    <button
                        type="button"
                        @click="projects_carousel.next()"
                        class="flex items-center justify-center w-10 h-10 p-2 bg-white rounded-lg shadow-md cursor-pointer shrink-0"
                    >
                        <SvgLoader class="shrink-0 fill-gray-700" name="chevron_right" />
                    </button>
                </div>
            </div>

            <div class="relative">
                <LargeSquarePattern class="absolute bottom-0 hidden shrink-0 fill-primary-300 md:block right-1/2" />

                <Carousel
                    class="relative w-screen py-9"
                    v-bind="carouselOptions.settings"
                    :breakpoints="carouselOptions.breakpoints"
                    ref="projects_carousel"
                >
                    <Slide
                        v-for="(project, index) in projects.data"
                        :key="index"
                        class="flex flex-col w-full px-4 rounded-lg"
                    >
                        <ProjectCard
                            cardType="client"
                            :class="['w-full rounded-lg', getCardClass(index)]"
                            :project="project"
                        />
                    </Slide>
                </Carousel>
                <div class="relative w-full mx-auto lg:max-w-7xl"></div>
            </div>
        </section>

        <div v-if="articles.data.length" class="w-full bg-primary-50 py-9">
            <div class="w-full mx-auto rounded lg:max-w-7xl px-9">
                <div class="flex items-center gap-6 mb-9">
                    <h2 class="text-2xl font-bold text-cyan-900 lg:text-5xl">{{ $t('articles') }}</h2>
                    <Link
                        :href="route('articles.index')"
                        class="bg-primary-500 text-center w-full sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                    >
                        {{ $t('see_all_articles') }}
                    </Link>
                </div>

                <ul role="list" class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                    <ArticleCard
                        v-for="(article, index) in articles.data"
                        :key="index"
                        :article="article"
                        class="relative"
                    />
                </ul>
            </div>
        </div>

        <!-- Bcr projects -->
        <section v-if="bcr_projects">
            <div class="container flex flex-wrap justify-between gap-6 lg:items-center">
                <h1
                    class="w-full text-4xl font-extrabold leading-6 tracking-tight text-cyan-900 lg:text-5xl xl:text-6xl lg:w-auto"
                    v-text="$t('bcr_for_community')"
                />

                <div class="lg:flex-1">
                    <Link
                        :href="route('bcr.index')"
                        class="w-full inline-block font-semibold leading-6 text-center text-white bg-primary-500 rounded-md shadow-sm lg:px-6 lg:py-4 lg:text-lg sm:w-auto hover:bg-primary-400 focus-visible:outline-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 px-3.5 py-2.5 text-sm"
                        v-text="$t('see_bcr_projects')"
                    />
                </div>

                <div class="flex items-center gap-6">
                    <button
                        type="button"
                        @click="bcr_projects_carousel.prev()"
                        class="flex items-center justify-center w-10 h-10 p-2 bg-white rounded-lg shadow-md cursor-pointer shrink-0"
                    >
                        <SvgLoader class="shrink-0 fill-gray-700" name="chevron_left" />
                    </button>

                    <button
                        type="button"
                        @click="bcr_projects_carousel.next()"
                        class="flex items-center justify-center w-10 h-10 p-2 bg-white rounded-lg shadow-md cursor-pointer shrink-0"
                    >
                        <SvgLoader class="shrink-0 fill-gray-700" name="chevron_right" />
                    </button>
                </div>
            </div>

            <Carousel
                class="relative w-screen py-9"
                v-bind="carouselOptions.settings"
                :breakpoints="carouselOptions.breakpoints"
                ref="bcr_projects_carousel"
            >
                <Slide
                    v-for="(project, index) in bcr_projects.data"
                    :key="index"
                    class="flex flex-col w-full px-4 rounded-lg"
                >
                    <ProjectCard
                        cardType="client"
                        :class="['w-full rounded-lg', getCardClass(index)]"
                        :project="project"
                    />
                </Slide>
            </Carousel>
        </section>
    </PageLayout>
</template>

<script setup>
    /** Import from vue */
    import { ref } from 'vue';
    import route from '@/Helpers/useRoute';

    /** Import plugins */
    import 'vue3-carousel/dist/carousel.css';
    import { Carousel, Slide } from 'vue3-carousel';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Head from '@/Components/Head.vue';
    import Icon from '@/Components/Icon.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import ProjectCard from '@/Components/cards/ProjectCard.vue';
    import ArticleCard from '@/Components/cards/ArticleCard.vue';

    import HeroPattern from '@/Components/patterns/HeroPattern.vue';
    import LargeSquarePattern from '@/Components/patterns/LargeSquarePattern.vue';
    import SmallSquarePattern from '@/Components/patterns/SmallSquarePattern.vue';

    /** Component props. */
    const props = defineProps({
        projects_count: Number,
        organizations_count: Number,
        projects: Object,
        bcr_projects: Object,
        donate_projects: Object,
        articles: Object,
    });

    const bcr_projects_carousel = ref(null);
    const projects_carousel = ref(null);

    const carouselOptions = ref({
        settings: {
            itemsToShow: 1,
            snapAlign: 'start',
            wrapAround: true,
            itemsToScroll: 1,
        },
        breakpoints: {
            700: {
                itemsToShow: 2,
                snapAlign: 'start',
                wrapAround: true,
                itemsToScroll: 1,
            },
            850: {
                itemsToShow: 2.5,
                snapAlign: 'start',
                wrapAround: true,
                itemsToScroll: 1,
            },
            1024: {
                itemsToShow: 3,
                snapAlign: 'start',
                wrapAround: true,
                itemsToScroll: 3,
            },
            1200: {
                itemsToShow: 3.5,
                snapAlign: 'start',
                wrapAround: true,
            },
            1440: {
                itemsToShow: 4.5,
                snapAlign: 'start',
                wrapAround: true,
                itemsToScroll: 3,
            },
            1700: {
                itemsToShow: 5.5,
                snapAlign: 'start',
                wrapAround: true,
                itemsToScroll: 3,
            },
        },
    });

    const getCardClass = (index) => {
        let pattern = ['md:mt-16', 'md:-mt-16', 'md:mt-0'];

        return pattern[index % pattern.length];
    };
</script>
