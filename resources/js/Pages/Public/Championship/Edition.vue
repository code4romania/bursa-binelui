<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('championship_title')" />

        <!-- Header -->
        <div class="relative w-full">
            <div class="flex flex-col-reverse w-full gap-10 mx-auto lg:flex-row lg:max-w-7xl px-9">
                <div class="relative flex flex-col w-full mt-10 lg:w-6/12">
                    <h1 class="relative z-50 text-2xl font-extrabold text-gray-900 lg:text-6xl xl:w-96">
                        {{ $t('championship_title') }}
                    </h1>
                    <p class="mt-6 text-base text-gray-500 lg:mb-0">{{ $t('competition') }}</p>
                </div>

                <div
                    class="relative items-center justify-center hidden w-full mt-10 lg:px-20 lg:pb-10 lg:w-6/12 sm:flex"
                >
                    <div class="relative flex items-center w-full">
                        <img class="w-full" src="/images/championship.png" alt="" />
                    </div>
                </div>
            </div>

            <div class="absolute left-0 hidden -top-16 md:block">
                <SvgLoader class="shrink-0 fill-primary-300" name="big_troffe" />
            </div>
        </div>

        <!-- Statistics -->
        <div class="mx-auto mb-10 max-w-7xl">
            <div class="flex items-center gap-x-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                    <SvgLoader class="shrink-0 fill-primary-500" name="brand" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $t('general_statistics') }}</h2>
            </div>

            <Table class="w-full mt-6" :columns="['LUNA', 'NUMAR DONATII', 'SUMA DORITA']">
                <tr v-for="stat in statistics" :key="stat.id">
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{ stat.month }}</td>
                    <td class="px-3 py-4 text-sm text-gray-900 whitespace-nowrap">{{ stat.donations }}</td>
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{ stat.amount }}</td>
                </tr>
            </Table>
        </div>

        <!-- Stats -->
        <div class="w-full bg-primary-500">
            <div class="flex flex-col items-center justify-between max-w-5xl gap-6 mx-auto mb-10 p-9 md:flex-row">
                <div class="text-center">
                    <h3 class="text-6xl font-bold text-white">243</h3>
                    <p class="text-2xl font-bold text-white">{{ $t('register_projects') }}</p>
                </div>
                <div class="text-center">
                    <h3 class="text-6xl font-bold text-white">243</h3>
                    <p class="text-2xl font-bold text-white">{{ $t('donors') }}</p>
                </div>
                <div class="text-center">
                    <h3 class="text-6xl font-bold text-white">243</h3>
                    <p class="text-2xl font-bold text-white">{{ $t('amount') }}</p>
                </div>
            </div>
        </div>

        <!-- About -->
        <div class="mx-auto mb-10 max-w-7xl p-9 md:flex-row">
            <h3 class="mb-6 text-3xl font-bold text-cyan-900">{{ $t('about_championship') }}</h3>
            <div class="text-base font-normal text-gray-500" v-html="about_championship"></div>
        </div>

        <!-- Projects -->
        <div class="mx-auto mb-10 p-9 max-w-7xl">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                    <SvgLoader class="shrink-0 fill-primary-500" name="list" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $t('participants') }}</h2>
            </div>

            <div class="flex flex-col items-center justify-between gap-6 lg:flex-row">
                <div class="flex flex-col items-center w-full gap-6 my-10 sm:flex-row xl:w-8/12">
                    <!-- Search -->
                    <div class="flex gap-6">
                        <SearchFilter
                            id="project-search"
                            class="w-full lg:w-96"
                            v-model="filter.s"
                            color="gray-700"
                            :placeholder="$t('search')"
                            @keydown.enter="filterProjects"
                        />

                        <!-- Search action -->
                        <SecondaryButton @click="filterProjects" class="py-2">
                            {{ $t('search') }}
                        </SecondaryButton>
                    </div>

                    <div class="flex w-full gap-6 mb-6 sm:mb-0">
                        <!-- Empty filters. -->
                        <SecondaryButton
                            v-if="hasValues"
                            @click="emptyFilters"
                            class="flex items-center w-1/2 gap-2 py-2 sm:w-auto"
                        >
                            <SvgLoader name="close" />
                            {{ $t('empty_filters') }}
                        </SecondaryButton>

                        <!-- Sort -->
                        <Sort class="w-1/2 sm:w-auto" />
                    </div>
                </div>

                <Select class="z-50 w-48" v-model="filter.stage" :options="stages" />
            </div>

            <h2 class="text-2xl font-bold text-gray-900">{{ query.total }} {{ $t('of_projects') }}</h2>

            <!-- Published projects -->
            <PaginatedGrid
                type="project"
                cardType="client"
                :list="query"
                classes="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 mb-4"
            />
        </div>

        <!-- Testimonials -->
        <div class="w-full bg-cyan-900">
            <div class="flex items-center mx-auto max-w-7xl p-9 gap-x-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                    <SvgLoader class="shrink-0 fill-white" name="quote" />
                </div>
                <h2 class="text-2xl font-bold text-white">{{ $t('testimonials') }}</h2>
            </div>
        </div>

        <!-- Carousel -->
        <div class="relative overflow-hidden bg-gray-50">
            <div class="flex items-center max-w-5xl mx-auto mt-12 mb-8 p-9 gap-x-4">
                <carousel
                    class="w-full"
                    :items-to-show="1"
                    :autoplay="4000"
                    :pauseAutoplayOnHover="true"
                    :wrapAround="true"
                    :transition="300"
                >
                    <slide v-for="(testimonial, index) in testimonials" :key="index" class="flex flex-col">
                        <p class="text-2xl font-medium text-gray-900">&ldquo;{{ testimonial.content }}&rdquo;</p>

                        <p class="mt-6">
                            <span class="text-base font-medium text-gray-900">{{ testimonial.name }} / </span>
                            <span class="text-base font-medium text-gray-500"
                                >{{ testimonial.job }}, {{ testimonial.company }}</span
                            >
                        </p>
                    </slide>
                </carousel>
            </div>

            <LargeSquarePattern class="absolute hidden md:block -bottom-32 -left-16 fill-gray-200" />
        </div>

        <!-- Articles -->
        <div class="relative mb-10 overflow-hidden pb-9">
            <div class="pt-12 pb-20 bg-primary-500 px-9 lg:px-0">
                <div class="flex items-center gap-4 mx-auto max-w-7xl">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-100">
                        <SvgLoader class="shrink-0 stroke-white fill-primary-100" name="sound" />
                    </div>
                    <h3 class="text-2xl font-bold text-white">{{ $t('related_articles') }}</h3>
                </div>
            </div>

            <div class="relative bg-white">
                <ul
                    role="list"
                    class="grid grid-cols-1 gap-8 mx-auto -mt-12 lg:mt-0 max-w-7xl sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3"
                >
                    <ArticleCard
                        v-for="article in articles"
                        :key="article.id"
                        :data="article"
                        class="relative z-50 lg:-mt-12"
                    />
                </ul>

                <LargeSquarePattern class="absolute top-0 right-0 z-10 hidden lg:block fill-primary-200" />
            </div>
        </div>

        <!-- External links -->
        <div class="mx-auto max-w-7xl p-9 gap-x-4">
            <div class="flex items-center mx-auto mb-10 max-w-7xl gap-x-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                    <SvgLoader class="shrink-0 fill-primary-500" name="links" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $t('external_links_title') }}</h2>
            </div>

            <div class="border-l-8 border-primary-500">
                <div v-for="(link, index) in links" :key="index" class="ml-4">
                    <a class="text-base font-medium text-blue-500" :href="link.href" target="_blank">
                        <span class="underline">{{ link.label }}</span>
                        <span class="text-gray-900">- {{ link.source }}</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Prev editions -->
        <div class="mx-auto mb-20 max-w-7xl p-9 gap-x-4">
            <div class="flex items-center mx-auto mb-10 max-w-7xl gap-x-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                    <SvgLoader class="shrink-0 fill-primary-500" name="clock" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $t('prev_edtions') }}</h2>
            </div>

            <div class="flex flex-col gap-y-4">
                <Link
                    v-for="(edition, index) in editions"
                    :key="index"
                    :href="route('edition', edition.href)"
                    class="text-xl font-bold text-blue-500"
                >
                    {{ edition.name }}
                </Link>
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
    /** Import from vue */
    import { ref } from 'vue';

    /** Import from inertia. */
    import { Head, Link, useForm, router } from '@inertiajs/vue3';

    /** Import plugins */
    import 'vue3-carousel/dist/carousel.css';
    import { Carousel, Slide } from 'vue3-carousel';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import PaginatedGrid from '@/Components/templates/PaginatedGrid.vue';
    import Sort from '@/Components/filters/Sort.vue';
    import Icon from '@/Components/Icon.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import SearchFilter from '@/Components/filters/SearchFilter.vue';
    import Input from '@/Components/form/Input.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import Modal from '@/Components/modals/Modal.vue';
    import ArticleCard from '@/Components/cards/ArticleCard.vue';
    import Select from '@/Components/form/Select.vue';
    import Table from '@/Components/templates/Table.vue';

    import LargeSquarePattern from '@/Components/patterns/LargeSquarePattern.vue';

    const about_championship =
        'Purus morbi dignissim senectus mattis adipiscing. Amet, massa quam varius orci dapibus volutpat cras. In amet eu ridiculus leo sodales cursus tristique. Tincidunt sed tempus ut viverra ridiculus non molestie. Gravida quis fringilla amet eget dui tempor dignissim. Facilisis auctor venenatis varius nunc, congue erat ac. Cras fermentum convallis quam.';

    /** Component props. */
    const props = defineProps({
        query: Object,
        championship: Object,
        testimonials: Array,
        editions: Array,
        links: Array,
        articles: Array,
        statistics: Array,
    });

    /** Active filter state. */
    const hasValues = ref(false);

    /** Filter values. */
    const filter = ref({
        stage: 'Etapa curenta',
        sort: '',
        s: '',
    });

    /** Filter projects. */
    const filterProjects = () => {
        if (Object.values(filter.value).every((value) => value === null)) {
            hasValues.value = false;
        } else {
            hasValues.value = true;
        }
    };

    /** Empty filters. */
    const emptyFilters = () => {
        router.visit(route('championship'));
    };

    /** Form variables. */
    const form = useForm({
        email: '',
        password: '',
        remember: false,
    });

    /** Submit action. */
    const submit = () => {
        form.post(route('login'), {
            onFinish: () => form.reset('password'),
        });
    };

    const stages = ['Etapa curenta', 'Etapa precendenta'];
</script>
