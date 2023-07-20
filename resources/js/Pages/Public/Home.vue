<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head title="Acasa" />

        <!-- Header -->
        <header class="flex flex-col-reverse w-full mx-auto lg:gap-10 xl:gap-20 lg:flex-row lg:max-w-7xl px-9">
            <div class="w-full lg:w-6/12 lg:py-12">
                <h1 :class="['relative z-50 text-2xl font-extrabold text-gray-900 lg:text-6xl']">{{ $t('home_title') }}</h1>

                <div class="relative flex flex-col items-center pb-10 my-10 md:flex-row gap-x-6">
                    <Link
                        :href="route('projects')"
                        class="bg-primary-500 text-center z-50 flex-1 w-full sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                    >
                        {{ $t('donate_to_a_project') }}
                    </Link>

                    <Link
                        :href="route('evolution')"
                        class="rounded-md flex-1 bg-white text-center px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 py-2.5"
                    >
                        {{ $t('see_evolution') }}
                    </Link>

                    <div class="absolute top-0 hidden -left-16 md:block">
                        <SvgLoader class="shrink-0 fill-primary-300" name="small_dotted_square" />
                    </div>
                </div>

                <div class="flex flex-col items-center gap-16 mx-auto md:flex-row">
                    <div>
                        <h3 class="text-6xl font-bold text-gray-900">900+</h3>
                        <p class="text-xl text-gray-900">{{ $t('projects') }}</p>
                    </div>
                    <div>
                        <h3 class="text-6xl font-bold text-gray-900">700+</h3>
                        <p class="text-xl text-gray-900">{{ $t('organizations') }}</p>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-6/12">
                <SvgLoader name="home_bg" class="w-full" />
            </div>
        </header>

        <div class="relative z-50 pb-10 mt-10 overflow-hidden px-9">
            <div class="relative z-50 w-full py-10 mx-auto rounded shadow-md lg:max-w-7xl lg:pl-32 lg:pr-10">
                <div class="lg:max-w-5xl">
                    <div class="flex items-center w-full mb-4">
                        <div class="relative z-30 flex-1 p-6 border border-gray-300" style="transform: skewX(29deg); transform-origin: top left; overflow: hidden;">
                            <div class="flex items-center justify-center gap-x-2" style="transform: skewX(-29deg);">
                                <p>un program</p>
                                <SvgLoader name="code4_logo"/>
                            </div>
                        </div>
                        <div class="relative z-50 flex items-center justify-center flex-1 p-6 bg-white border border-gray-300 gap-x-2">
                            <p>un program</p>
                            <SvgLoader name="code4_logo"/>
                        </div>
                    </div>

                    <div class="inline-flex flex-col">
                        <h3 class="inline px-6 py-2 text-2xl font-bold text-white bg-red-500 w-fit">ONG-URILE DE PE BURSA BINELUI</h3>
                        <h3 class="inline px-6 py-2 text-xl font-bold text-white w-fit bg-primary-500">Se pot programa la CiviTech 911. Afla cum aici...</h3>
                    </div>
                </div>

                <div class="absolute left-0 hidden -ml-20 bottom-10 md:block">
                    <SvgLoader class="shrink-0 fill-primary-300" name="small_dotted"/>
                </div>
            </div>

            <div class="absolute bottom-0 right-0 z-10 hidden md:block">
                <SvgLoader class="z-10 shrink-0 fill-primary-300" name="dotted_square" />
            </div>
        </div>

        <div v-if="donate_projects" class="flex items-center justify-between w-full gap-6 mx-auto mt-10 lg:max-w-7xl px-9">

           <div class="flex items-center gap-6">
                <h2 class="text-2xl font-bold text-red-500 lg:text-5xl">{{ $t('donate_for_good') }}</h2>
                <Link
                    :href="route('projects')"
                    class="bg-red-500 text-center z-50 w-full sm:w-auto hover:bg-red-400 text-white focus-visible:outline-red-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                >
                    {{ $t('find_projects') }}
                </Link>
           </div>

           <div class="flex items-center gap-6">
                <div @click="donate_projects_carousel.prev()" class="flex items-center justify-center w-10 h-10 p-2 bg-white rounded-lg shadow-md cursor-pointer">
                    <SvgLoader class="shrink-0 fill-gray-700" name="chevron_left"/>
                </div>

                <div @click="donate_projects_carousel.next()" class="flex items-center justify-center w-10 h-10 p-2 bg-white rounded-lg shadow-md cursor-pointer">
                    <SvgLoader class="shrink-0 fill-gray-700" name="chevron_right"/>
                </div>
           </div>
        </div>

        <div v-if="donate_projects" class="relative w-full">
            <carousel
                class="relative z-50 w-full"
                v-bind="carouselOptions.settings"
                :breakpoints="carouselOptions.breakpoints"
                ref="donate_projects_carousel"
            >
                <slide
                    v-for="(project, index) in donate_projects.data"
                    :key="index"
                    class="flex flex-col w-full rounded-lg py-9"
                >
                    <ProjectCard
                        cardType="client"
                        :class="['w-full rounded-lg', getCardClass(index)]"
                        :data="project"
                    />
                </slide>
            </carousel>
            <div class="relative w-full mx-auto lg:max-w-7xl">
                <div class="absolute bottom-0 hidden md:block left-60">
                    <SvgLoader class="shrink-0 fill-primary-300" name="dotted_square" />
                </div>
            </div>
        </div>

        <div v-if="articles.length" class="w-full bg-primary-50 py-9">
            <div class="w-full mx-auto rounded lg:max-w-7xl px-9">
                <div class="flex items-center gap-6 mb-9">
                    <h2 class="text-2xl font-bold text-cyan-900 lg:text-5xl">{{ $t('articles') }}</h2>
                    <Link
                        :href="route('articles')"
                        class="bg-primary-500 text-center z-50 w-full sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                    >
                        {{ $t('see_all_articles') }}
                    </Link>
                </div>

                <ul role="list" class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                    <ArticleCard
                        v-for="article in articles"
                        :key="article.id"
                        :data="article"
                        class="relative z-50"
                    />
                </ul>
            </div>
        </div>

        <!-- Bcr projects -->
        <div v-if="bcr_projects" class="relative w-full bg-white">
            <div class="flex items-center justify-between w-full gap-6 mx-auto mt-10 lg:max-w-7xl px-9">
                <div class="flex items-center gap-6">
                    <h2 class="text-2xl font-bold text-cyan-900 lg:text-5xl">{{ $t('bcr_for_community') }}</h2>
                    <Link
                        :href="route('projects')"
                        class="bg-primary-500 text-center z-50 w-full sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                    >
                        {{ $t('see_bcr_projects') }}
                    </Link>
                </div>

                <div class="flex items-center gap-6">
                    <div @click="bcr_projects_carousel.prev()" class="flex items-center justify-center w-10 h-10 p-2 bg-white rounded-lg shadow-md cursor-pointer">
                        <SvgLoader class="shrink-0 fill-gray-700" name="chevron_left"/>
                    </div>

                    <div @click="bcr_projects_carousel.next()" class="flex items-center justify-center w-10 h-10 p-2 bg-white rounded-lg shadow-md cursor-pointer">
                        <SvgLoader class="shrink-0 fill-gray-700" name="chevron_right"/>
                    </div>
                </div>
            </div>

            <carousel
                class="relative z-50 w-full"
                v-bind="carouselOptions.settings"
                :breakpoints="carouselOptions.breakpoints"
                ref="bcr_projects_carousel"
            >
                <slide
                    v-for="(project, index) in bcr_projects.data"
                    :key="index"
                    class="flex flex-col w-full rounded-lg py-9"
                >
                    <ProjectCard
                        cardType="client"
                        :class="['w-full rounded-lg', getCardClass(index)]"
                        :data="project"
                    />
                </slide>
            </carousel>
        </div>
    </PageLayout>
</template>

<script setup>
    /** Import from vue */
    import { ref } from 'vue';

    /** Import from inertia. */
    import { Head, Link } from '@inertiajs/vue3';

    /** Import plugins */
    import 'vue3-carousel/dist/carousel.css';
    import { Carousel, Slide } from 'vue3-carousel';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import ProjectCard from '@/Components/cards/ProjectCard.vue'
    import ArticleCard from '@/Components/cards/ArticleCard.vue';

    /** Component props. */
    const props = defineProps({
        query: Object,
        bcr_projects: Object,
        donate_projects: Object,
        articles: Array
    });

    const bcr_projects_carousel = ref(null);
    const donate_projects_carousel = ref(null);

    const carouselOptions = ref({
        settings: {
            itemsToShow: 1,
            snapAlign: 'start',
        },
        breakpoints: {
            700: {
                itemsToShow: 2,
                snapAlign: 'start',
            },
            850: {
                itemsToShow: 2.5,
                snapAlign: 'start',
            },
            1024: {
                itemsToShow:3,
                snapAlign: 'start',
                wrapAround: true,
            },
            1200: {
                itemsToShow:3.5,
                snapAlign: 'start',
                wrapAround: true,
            },
            1440: {
                itemsToShow:4.5,
                snapAlign: 'start',
                wrapAround: true,
            },
            1700: {
                itemsToShow:5.5,
                snapAlign: 'start',
                wrapAround: true,
            }
        },
    });

    const carouselPattern = ['md:mt-16', 'md:-mt-16', 'md:mt-0'];
    const getCardClass = ((index) => carouselPattern[index % carouselPattern.length]);
</script>
<style>
    @media only screen and (min-width: 768px) {
        .carousel__track{
            display: flex;
            gap: 24px;
        }
    }
</style>
