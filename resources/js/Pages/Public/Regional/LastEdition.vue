<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('bb_regional_title')" />

        <!-- Header -->
        <div class="relative w-full">
            <div class="flex flex-col-reverse w-full gap-10 mx-auto lg:flex-row lg:max-w-7xl px-9">
                <div class="relative flex flex-col w-full mt-10 lg:w-6/12">
                    <h1 class="relative z-50 text-2xl font-extrabold text-gray-900 lg:text-6xl">
                        {{ $t('bb_regional_title') }}
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
                <SvgLoader class="shrink-0 fill-primary-300" name="location_extra" />
            </div>
        </div>

        <!-- Countdown -->
        <div :class="['winners' === status ? 'bg-red-500' : 'bg-primary-500', 'w-full']">
            <div class="flex flex-col items-center justify-center max-w-5xl gap-6 mx-auto mb-10 p-9 md:flex-row">
                <Countdown :dates="registration" />
            </div>
        </div>

        <!-- About -->
        <div class="mx-auto mb-10 max-w-7xl p-9 md:flex-row">
            <h3 class="mb-6 text-3xl font-bold text-cyan-900">{{ $t('about_regional') }}</h3>
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

                <MultiSelectObjectFilter
                    class="z-50 w-60"
                    v-model="filter.c"
                    :options="countries"
                    @callback="filterProjects"
                />
            </div>

            <h2 class="text-2xl font-bold text-gray-900">{{ query.total }} {{ $t('of_projects') }}</h2>

            <!-- Published projects -->
            <PaginatedGrid
                cardType="project-regional"
                :list="query"
                classes="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 mb-4"
            />
        </div>

        <div class="mx-auto mb-10 max-w-7xl p-9 md:flex-row">
            <h2 class="mb-4 text-3xl font-bold text-cyan-900">{{ $t('faqs_title') }}</h2>
            <Faqs :data="faqs" />
            <div class="mt-10">
                <Link
                    :href="route('contact')"
                    class="bg-primary-500 flex-1 text-center sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                >
                    {{ $t('contact_us') }}
                </Link>
            </div>
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
                        :article="article"
                        class="relative z-50 lg:-mt-12"
                    />
                </ul>

                <LargeSquarePattern class="absolute top-0 right-0 z-10 hidden lg:block fill-primary-200" />
            </div>
        </div>

        <!-- Parteners -->
        <div class="relative mb-10 overflow-hidden pb-9">
            <div class="pt-12 pb-20 bg-primary-500 px-9 lg:px-0">
                <div class="flex items-center gap-4 mx-auto max-w-7xl">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-100">
                        <SvgLoader class="shrink-0 stroke-white fill-primary-100" name="sound" />
                    </div>
                    <h3 class="text-2xl font-bold text-white">{{ $t('parteners') }}</h3>
                </div>
            </div>

            <div class="relative bg-white">
                <ul
                    role="list"
                    class="grid grid-cols-1 gap-8 mx-auto lg:-mt-12 max-w-7xl sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3"
                >
                    <li
                        v-for="(partener, index) in parteners"
                        :key="index"
                        class="relative z-50 flex flex-col col-span-1 p-10 bg-white rounded-lg shadow-md"
                    >
                        <img :src="partener" />
                    </li>
                </ul>

                <LargeSquarePattern class="absolute top-0 right-0 z-10 hidden lg:block fill-primary-200" />
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
    import route from '@/Helpers/useRoute';

    /** Import from inertia. */
    import { Link, useForm, router } from '@inertiajs/vue3';
    import Head from '@/Components/Head.vue';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Input from '@/Components/form/Input.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import Modal from '@/Components/modals/Modal.vue';
    import ArticleCard from '@/Components/cards/ArticleCard.vue';
    import ChampionshipModal from '@/Components/modals/ChampionshipModal.vue';
    import ProjectSummaryCard from '@/Components/cards/ProjectSummaryCard.vue';
    import Countdown from '@/Components/timers/Countdown.vue';
    import Faqs from '@/Components/faqs/Faqs.vue';
    import PaginatedGrid from '@/Components/templates/PaginatedGrid.vue';
    import Sort from '@/Components/filters/Sort.vue';
    import SearchFilter from '@/Components/filters/SearchFilter.vue';
    import MultiSelectObjectFilter from '@/Components/filters/MultiSelectObjectFilter.vue';

    import LargeSquarePattern from '@/Components/patterns/LargeSquarePattern.vue';

    const about_championship =
        'Purus morbi dignissim senectus mattis adipiscing. Amet, massa quam varius orci dapibus volutpat cras. In amet eu ridiculus leo sodales cursus tristique. Tincidunt sed tempus ut viverra ridiculus non molestie. Gravida quis fringilla amet eget dui tempor dignissim. Facilisis auctor venenatis varius nunc, congue erat ac. Cras fermentum convallis quam.';

    /** Component props. */
    const props = defineProps({
        query: Object,
        championship: Object,
        testimonials: Array,
        editions: Array,
        articles: Array,
        registration: Object,
        parteners: Array,
        faqs: Array,
        countries: Array,
    });

    /** Active filter state. */
    const hasValues = ref(false);

    /** Filter values. */
    const filter = ref({
        stage: 'Etapa curenta',
        sort: '',
        s: '',
        c: '',
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

    const name = ref('');
    const test = (project) => {
        const form = useForm({ ...project });
        name.value = project.name;

        // form.post(route('need.subscribe.route'), {
        //     onSuccess: () => {
        //         document.getElementById('championship-modal').click()
        //         document.getElementById('championship-success').click()
        //     },
        // });

        document.getElementById('championship-modal').click();
        document.getElementById('championship-success').click();
    };

    const closeSucces = () => document.getElementById('championship-success').click();

    const stages = ['Etapa curenta', 'Etapa precendenta'];
</script>
