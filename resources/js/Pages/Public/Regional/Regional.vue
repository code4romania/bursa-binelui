<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('regional_title')" />

        <div class="w-full lg:hidden">
            <img class="w-full" src="/images/championship.png" alt="" />
        </div>

        <!-- Header -->
        <div class="flex flex-col-reverse w-full gap-10 mx-auto lg:my-10 lg:flex-row lg:max-w-7xl sm:mt-0 px-9">
            <div class="relative flex flex-col w-full lg:w-6/12">

                <h1 class="relative z-50 text-2xl font-extrabold text-gray-900 lg:py-12 lg:text-6xl">{{ $t('regional_title') }}</h1>

                <p class="my-6 text-base text-gray-500 lg:hidden lg:mb-0">{{ $t('competition') }}</p>

                <div class="flex flex-col w-full gap-4 mb-6 lg:mb-0 sm:flex-row">

                    <!-- Register -->
                    <Modal
                        v-if="$page.props.auth.user"
                        triggerModalClasses="bg-turqoise-500 w-full sm:w-auto hover:bg-turqoise-400 text-white focus-visible:outline-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        :triggerModalText="$t('register_project')"
                    >
                        <form class="mt-6 space-y-6" @submit.prevent="submit">
                            <h3 class="text-lg font-semibold text-center text-gray-900">Intră în contul organizației tale pentru a inscrie un proiect</h3>
                            <p class="text-base text-center text-gray-500">Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim.</p>

                            <!-- Email. -->
                            <Input
                                :label="$t('email')"
                                id="email"
                                type="email"
                                v-model="form.email"
                                :isRequired="true"
                                color="gray-700"
                                hasAutocomplete="username"
                                :error="form.errors.email"
                            />

                            <!-- Passowrd. -->
                            <Input
                                :label="$t('password')"
                                id="password"
                                type="password"
                                v-model="form.password"
                                :isRequired="true"
                                color="gray-700"
                                hasAutocomplete="current-password"
                                :error="form.errors.password"
                            />

                            <!-- Action -->
                            <div class="space-y-6">

                                <!-- Log in button -->
                                <PrimaryButton
                                    background="turqoise-500"
                                    hover="turqoise-400"
                                    color="white"
                                    class="w-full"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    {{ $t('log_in') }}
                                </PrimaryButton>

                                <SecondaryButton
                                    class="flex items-center w-full justify-center gap-x-2 py-2.5"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    <!-- <SvgLoader name="google" class="shrink-0" /> -->
                                    {{ $t('google_log_in') }}
                                </SecondaryButton>

                                <Link
                                    :href="route('register')"
                                    class="flex justify-center text-base text-gray-900 gap-x-1"
                                >
                                    {{ $t('no_account') }} <span class="text-turqoise-500">{{ $t('register') }}</span>
                                </Link>
                            </div>
                        </form>

                    </Modal>

                    <!-- Add Project -->
                    <ChampionshipModal
                        v-if="!$page.props.auth.user"
                    >

                       <div class="px-9">
                            <SecondaryButton
                                class="flex items-center flex-1 gap-x-2 py-2.5 my-10"
                            >
                                <SvgLoader name="add" />
                                {{ $t("add_new_project") }}
                            </SecondaryButton>
                       </div>

                        <div v-if="query.data.length" class="grid grid-cols-1 mb-4 overflow-y-auto gap-x-8 gap-y-12 px-9 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 max-h-128">
                            <ProjectSummaryCard
                                v-for="data in query.data"
                                :data="data"
                                @choosed="test"
                            />
                        </div>
                    </ChampionshipModal>

                    <Modal
                        id="championship-success"
                        triggerModalClasses="hidden bg-turqoise-500 w-full sm:w-auto hover:bg-turqoise-400 text-white focus-visible:outline-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        :triggerModalText="$t('register_project')"
                    >
                        <div class="flex flex-col items-center w-full my-4 space-y-3">
                            <SvgLoader name="success" class="fill-green-200" />

                            <h3 class="text-lg font-bold text-gray-500">{{ $t('championship_success_title') }}</h3>

                            <p class="text-lg font-bold text-turqoise-500">{{ name }}</p>

                            <p class="text-sm text-center text-gray-500">{{ $t('championship_success_description') }}</p>

                            <div class="flex items-center w-full gap-4">
                                <SecondaryButton
                                    class="flex items-center justify-center mt-6 flex-1 gap-x-2 py-2.5"
                                    @click="closeSucces"
                                >
                                    {{ $t("close") }}
                                </SecondaryButton>

                                <Link
                                    href="#"
                                    class="bg-turqoise-500 flex-1 text-center mt-6 sm:w-auto hover:bg-turqoise-400 text-white focus-visible:outline-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                                >
                                    {{ $t('championship_rules') }}
                                </Link>
                            </div>

                        </div>
                    </Modal>

                    <Link
                        :href="route('projects')"
                        class="rounded-md bg-white text-center px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 py-2.5"
                    >
                        {{ $t('see_projects') }}
                    </Link>
                </div>

                <p class="hidden mt-10 text-base text-gray-500 lg:block">
                    {{ $t('regional_rules') }}
                    <Link href="#" class="text-blue-500">{{ $t('here') }}.</Link>
                </p>


                <div class="absolute hidden md:block -top-24 -left-32">
                    <SvgLoader class="shrink-0 fill-turqoise-300" name="dotted_square" />
                </div>
            </div>

            <div class="relative items-center justify-center hidden w-full lg:px-20 lg:pb-20 lg:w-6/12 sm:flex">

                <div class="absolute bottom-0 right-0 hidden md:block">
                    <SvgLoader class="shrink-0 fill-turqoise-500" name="dotted_square" />
                </div>

                <div class="relative flex items-center bg-white rounded shadow w-fit">
                    <img class="mx-auto rounded-lg" src="/images/auth_image.jpg" alt="" />

                    <div class="absolute flex items-center justify-center w-32 h-32 rounded-lg bg-gray-50 -bottom-10 -left-10">
                        <SvgLoader class="shrink-0" name="location_big" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Countdown -->
        <div class="w-full bg-turqoise-500">
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
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-turqoise-500">
                    <SvgLoader class="shrink-0 fill-turqoise-500" name="list"/>
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
                        <SecondaryButton
                            @click="filterProjects"
                            class="py-2"
                        >
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
                        <Sort
                            class="w-1/2 sm:w-auto"
                        />
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

        <!-- Faqs -->
        <div class="mx-auto mb-10 max-w-7xl p-9 md:flex-row">
            <h2 class="mb-4 text-3xl font-bold text-cyan-900">{{ $t('faqs_title') }}</h2>
            <Faqs :data="faqs" />
            <div class="mt-10">
                <Link
                    :href="route('contact')"
                    class="bg-turqoise-500 flex-1 text-center  sm:w-auto hover:bg-turqoise-400 text-white focus-visible:outline-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                >
                    {{ $t('contact_us') }}
                </Link>
            </div>
        </div>

        <!-- Articles -->
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
                    <ArticleCard
                        v-for="article in articles"
                        :key="article.id"
                        :data="article"
                        class="relative z-50 lg:-mt-12"
                    />
                </ul>
            </div>

            <div class="absolute top-0 right-0 z-10 hidden lg:block">
                <SvgLoader class="shrink-0" name="squer_half_color" />
            </div>
        </div>

        <!-- Parteners -->
        <div class="relative mb-10 overflow-hidden pb-9">

            <div class="pt-12 pb-20 bg-turqoise-500 px-9 lg:px-0">
                <div class="flex items-center gap-4 mx-auto max-w-7xl">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-turqoise-100">
                        <SvgLoader class="shrink-0 stroke-white fill-turqoise-100" name="sound" />
                    </div>
                    <h3 class="text-2xl font-bold text-white">{{ $t('parteners') }}</h3>
                </div>
            </div>

            <div class=" px-9">
                <ul role="list" class="grid grid-cols-1 gap-8 mx-auto lg:-mt-12 max-w-7xl sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">

                    <li
                        v-for="(partener, index) in parteners"
                        :key="index"
                        class="relative z-50 flex flex-col col-span-1 p-10 bg-white rounded-lg shadow-md"
                    >
                        <img :src="partener">
                    </li>
                </ul>
            </div>

            <div class="absolute top-0 right-0 z-10 hidden lg:block">
                <SvgLoader class="shrink-0" name="squer_half_color" />
            </div>
        </div>

        <!-- Prev editions -->
        <div class="mx-auto mb-20 max-w-7xl p-9 gap-x-4">
            <div class="flex items-center mx-auto mb-10 max-w-7xl gap-x-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-turqoise-500">
                    <SvgLoader class="shrink-0 fill-turqoise-500" name="clock"/>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $t('prev_edtions') }}</h2>
            </div>

            <div class="flex flex-col gap-y-4">
                <Link
                    v-for="(edition, index) in editions"
                    :key="index"
                    :href="route('lastedition', edition.href)"
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

    const about_championship = 'Purus morbi dignissim senectus mattis adipiscing. Amet, massa quam varius orci dapibus volutpat cras. In amet eu ridiculus leo sodales cursus tristique. Tincidunt sed tempus ut viverra ridiculus non molestie. Gravida quis fringilla amet eget dui tempor dignissim. Facilisis auctor venenatis varius nunc, congue erat ac. Cras fermentum convallis quam.'

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
        countries: Array
    });

    /** Active filter state. */
    const hasValues = ref(false);

    /** Filter values. */
    const filter = ref({
        stage: 'Etapa curenta',
        sort: '',
        s: '',
        c: ''
    });

    /** Filter projects. */
    const filterProjects = () => {
        if (Object.values(filter.value).every(value => value === null)) {
            hasValues.value = false
        } else {
            hasValues.value = true
        }
    };

    /** Empty filters. */
    const emptyFilters = () => {
        router.visit(route('championship'))
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

    const name = ref('')
    const test = (project) => {
        const form =  useForm({...project});
        name.value = project.name

        // form.post(route('need.subscribe.route'), {
        //     onSuccess: () => {
        //         document.getElementById('championship-modal').click()
        //         document.getElementById('championship-success').click()
        //     },
        // });

        document.getElementById('championship-modal').click()
        document.getElementById('championship-success').click()
    }

    const closeSucces = (() => document.getElementById('championship-success').click())

    const stages = ['Etapa curenta', 'Etapa precendenta'];
</script>
