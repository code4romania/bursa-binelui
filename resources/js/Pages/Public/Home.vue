<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head title="Acasa" />

        <header class="flex flex-col-reverse w-full mx-auto lg:gap-10 xl:gap-20 lg:flex-row lg:max-w-7xl px-9">
            <div class="w-full lg:w-6/12 lg:py-12">
                <h1 class="relative z-50 text-2xl font-extrabold text-gray-900 lg:text-6xl">{{ $t('home_title') }}</h1>

                <div class="relative flex flex-col items-center pb-10 my-10 md:flex-row gap-x-6">
                    <Link
                        :href="route('admin.ong.project.add')"
                        class="bg-primary-500 text-center z-50 flex-1 w-full sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                    >
                        {{ $t('register_project') }}
                    </Link>

                    <Link
                        :href="route('projects')"
                        class="rounded-md flex-1 bg-white text-center px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 py-2.5"
                    >
                        {{ $t('see_projects') }}
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

        <div class="relative z-30 pb-10 mt-10 overflow-hidden px-9">
            <div class="relative z-30 w-full py-10 mx-auto rounded shadow-md lg:max-w-7xl lg:pl-32 lg:pr-10">

                <div class="lg:max-w-5xl">
                    <div class="flex items-center w-full mb-4">
                        <div class="relative z-30 flex-1 p-6 border border-gray-300" style="transform: skewX(29deg);transform-origin: top left; overflow: hidden;">
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

                <div class="absolute z-10 hidden bottom-10 -left-20 md:block">
                    <SvgLoader class="z-10 shrink-0 fill-primary-300" name="small_dotted"/>
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
                    {{ $t('register_project') }}
                </Link>
           </div>

           <div class="flex items-center gap-6">
                <div @click="projects.prev()" class="flex items-center justify-center w-10 h-10 p-2 bg-white rounded-lg shadow-md cursor-pointer">
                    <SvgLoader class="shrink-0 fill-gray-700" name="chevron_left"/>
                </div>

                <div @click="projects.next()" class="flex items-center justify-center w-10 h-10 p-2 bg-white rounded-lg shadow-md cursor-pointer">
                    <SvgLoader class="shrink-0 fill-gray-700" name="chevron_right"/>
                </div>
           </div>
        </div>

        <div v-if="donate_projects" class="relative w-full">
            <carousel
                class="relative z-50 w-full"
                v-bind="carouselOptions.settings"
                :breakpoints="carouselOptions.breakpoints"
                ref="projects"
            >
                <slide
                    v-for="(project, index) in donate_projects.data"
                    :key="index"
                    class="flex flex-col -mr-4 py-9"
                >
                    <ProjectCard
                        :class="['mx-4', 0 === index % 2 ? '-mt-9' : 'mt-9']"
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
                        :href="route('projects')"
                        class="bg-primary-500 text-center z-50 w-full sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                    >
                        {{ $t('register_project') }}
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
                        {{ $t('register_project') }}
                    </Link>
                </div>

                <div class="flex items-center gap-6">
                    <div @click="projects.prev()" class="flex items-center justify-center w-10 h-10 p-2 bg-white rounded-lg shadow-md cursor-pointer">
                        <SvgLoader class="shrink-0 fill-gray-700" name="chevron_left"/>
                    </div>

                    <div @click="projects.next()" class="flex items-center justify-center w-10 h-10 p-2 bg-white rounded-lg shadow-md cursor-pointer">
                        <SvgLoader class="shrink-0 fill-gray-700" name="chevron_right"/>
                    </div>
                </div>
            </div>

            <carousel
                class="relative z-50 w-full"
                v-bind="carouselOptions.settings"
                :breakpoints="carouselOptions.breakpoints"
                ref="projects"
            >
                <slide
                    v-for="(project, index) in bcr_projects.data"
                    :key="index"
                    class="flex flex-col py-9"
                >
                    <ProjectCard
                        :class="[0 === index % 2 ? '-mt-9' : 'mt-9']"
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

    const projects = ref(null);

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
                wrapAround: false,
            },
            1200: {
                itemsToShow:3.5,
                snapAlign: 'start',
                wrapAround: false,
            },
            1440: {
                itemsToShow:4.5,
                snapAlign: 'start',
                wrapAround: false,
            },
            1700: {
                itemsToShow:5.5,
                snapAlign: 'start',
                wrapAround: false,
            }
        },
    });
</script>

<style>
.carousel-container {
  display: flex;
  gap: 20px;
}

.carousel-slide {
  margin-right: 20px;
}
</style>
