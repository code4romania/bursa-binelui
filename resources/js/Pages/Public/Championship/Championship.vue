<template>
    <PageLayout>
        <!-- Inertia page head -->

        <Head :title="$t('championship_title')" />

        <div class="w-full lg:hidden">
            <img class="w-full" src="/images/championship.png" alt="" />
        </div>

        <!-- Header -->
        <div class="flex flex-col-reverse w-full gap-10 mx-auto lg:my-10 lg:flex-row lg:max-w-7xl sm:mt-0 px-9">
            <div class="relative flex flex-col w-full lg:w-6/12">

                <h1 class="relative z-50 text-2xl font-extrabold text-gray-900 lg:py-12 lg:text-6xl xl:w-96">{{
                    $t('championship_title') }}</h1>

                <p class="my-6 text-base text-gray-500 lg:hidden lg:mb-0">{{ $t('competition') }}</p>

                <div class="flex flex-col w-full gap-4 mb-6 lg:mb-0 sm:flex-row">

                    <!-- Register -->
                    <Modal v-if="!$page.props.auth.user"
                        triggerModalClasses="bg-primary-500 w-full sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        :triggerModalText="$t('register_project')">
                        <form class="mt-6 space-y-6" @submit.prevent="submit">
                            <h3 class="text-lg font-semibold text-center text-gray-900">Intră în contul organizației tale
                                pentru a inscrie un proiect</h3>
                            <p class="text-base text-center text-gray-500">Faucibus commodo massa rhoncus, volutpat.
                                Dignissim sed eget risus enim.</p>

                            <!-- Email. -->
                            <Input :label="$t('email')" id="email" type="email" v-model="form.email" :isRequired="true"
                                color="gray-700" hasAutocomplete="username" :error="form.errors.email" />

                            <!-- Passowrd. -->
                            <Input :label="$t('password')" id="password" type="password" v-model="form.password"
                                :isRequired="true" color="gray-700" hasAutocomplete="current-password"
                                :error="form.errors.password" />

                            <!-- Action -->
                            <div class="space-y-6">

                                <!-- Log in button -->
                                <PrimaryButton background="primary-500" hover="primary-400" color="white" class="w-full"
                                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    {{ $t('log_in') }}
                                </PrimaryButton>

                                <SecondaryButton class="flex items-center w-full justify-center gap-x-2 py-2.5"
                                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    <!-- <SvgLoader name="google" class="shrink-0" /> -->
                                    {{ $t('google_log_in') }}
                                </SecondaryButton>

                                <Link :href="route('register')" class="flex justify-center text-base text-gray-900 gap-x-1">
                                {{ $t('no_account') }} <span class="text-primary-500">{{ $t('register') }}</span>
                                </Link>
                            </div>
                        </form>

                    </Modal>

                    <!-- Add Project -->
                    <ChampionshipModal v-if="$page.props.auth.user" @click.once="infiniteScroll">

                        <div class="px-9">
                            <SecondaryButton class="flex items-center flex-1 gap-x-2 py-2.5 my-10">
                                <SvgLoader name="add" />
                                {{ $t("add_new_project") }}
                            </SecondaryButton>
                        </div>

                        <div v-if="infiniteProjects.length"
                            class="grid grid-cols-1 mb-4 overflow-y-auto gap-x-8 gap-y-12 px-9 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 max-h-128"
                            @scroll="infiniteAtScroll" id="parent"
                        >
                            <ProjectSummaryCard v-for="data in infiniteProjects" :data="data" @choosed="test" />
                        </div>
                    </ChampionshipModal>

                    <Modal id="championship-success"
                        triggerModalClasses="hidden bg-primary-500 w-full sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        :triggerModalText="$t('register_project')">
                        <div class="flex flex-col items-center w-full my-4 space-y-3">
                            <SvgLoader name="success" class="fill-green-200" />

                            <h3 class="text-lg font-bold text-gray-500">{{ $t('championship_success_title') }}</h3>

                            <p class="text-lg font-bold text-primary-500">{{ name }}</p>

                            <p class="text-sm text-center text-gray-500">{{ $t('championship_success_description') }}</p>

                            <div class="flex items-center w-full gap-4">
                                <SecondaryButton class="flex items-center justify-center mt-6 flex-1 gap-x-2 py-2.5"
                                    @click="closeSucces">
                                    {{ $t("close") }}
                                </SecondaryButton>

                                <Link href="#"
                                    class="bg-primary-500 flex-1 text-center mt-6 sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">
                                {{ $t('championship_rules') }}
                                </Link>
                            </div>

                        </div>
                    </Modal>

                    <button
                        @click="scrollTo('#projects')"
                        class="rounded-md bg-white text-center px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 py-2.5">
                        {{ $t('see_projects') }}
                    </button>
                </div>

                <p class="hidden mt-10 text-base text-gray-500 lg:block">{{ $t('competition') }}</p>

                <p class="hidden text-base text-gray-500 lg:block">
                    {{ $t('regional_rules') }}
                    <Link :href="route('championship.rules')" class="text-blue-500">{{ $t('here') }}.</Link>
                </p>

                <div class="absolute hidden md:block -top-24 -left-32">
                    <SvgLoader class="shrink-0 fill-primary-300" name="dotted_square" />
                </div>
            </div>

            <div class="relative items-center justify-center hidden w-full lg:px-20 lg:pb-20 lg:w-6/12 sm:flex">

                <div class="absolute bottom-0 right-0 hidden md:block">
                    <SvgLoader class="shrink-0 fill-primary-500" name="dotted_square" />
                </div>

                <div class="relative flex items-center p-8 bg-white rounded shadow w-fit">
                    <img class="mx-auto" src="/images/project_img.png" alt="" />

                    <div
                        class="absolute flex items-center justify-center w-32 h-32 rounded-lg bg-gray-50 -bottom-10 -left-10">
                        <SvgLoader class="shrink-0" name="cup" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="w-full bg-primary-500">
            <div class="flex flex-col items-center justify-between max-w-5xl gap-6 mx-auto mb-10 p-9 md:flex-row">
                <div class="text-center">
                    <h3 class="text-6xl font-bold text-white">{{projects.total}}</h3>
                    <p class="text-2xl font-bold text-white">{{ $t('register_projects') }}</p>
                </div>
                <div class="text-center">
                    <h3 class="text-6xl font-bold text-white">{{projectDonationsNumber}}</h3>
                    <p class="text-2xl font-bold text-white">{{ $t('donors') }}</p>
                </div>
                <div class="text-center">
                    <h3 class="text-6xl font-bold text-white">{{ projectAmount }}</h3>
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
        <div v-if="0 < projects?.data.length" id="projects" class="mx-auto mb-10 p-9 max-w-7xl">

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
                        <SearchFilter id="project-search" class="w-full lg:w-96" v-model="filter.s" color="gray-700"
                            :placeholder="$t('search')" @keydown.enter="filterProjects" />

                        <!-- Search action -->
                        <SecondaryButton @click="filterProjects" class="py-2">
                            {{ $t('search') }}
                        </SecondaryButton>
                    </div>

                    <div class="flex w-full gap-6 mb-6 sm:mb-0">
                        <!-- Empty filters. -->
                        <SecondaryButton v-if="hasValues" @click="emptyFilters"
                            class="flex items-center w-1/2 gap-2 py-2 sm:w-auto">
                            <SvgLoader name="close" />
                            {{ $t('empty_filters') }}
                        </SecondaryButton>

                        <!-- Sort -->
                        <Sort class="w-1/2 sm:w-auto" />
                    </div>
                </div>

                <Select class="z-50 w-48" v-model="filter.stage" :options="stages" />
            </div>

            <h2 class="text-2xl font-bold text-gray-900">{{ projects.total }} {{ $t('of_projects') }}</h2>

            <!-- Published projects -->
            <PaginatedGrid type="project" cardType="client" :list="projects"
                classes="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 mb-4" />
        </div>

        <!-- Testimonials -->
        <div v-if="0 < testimonials.length" class="w-full bg-cyan-900">
            <div class="flex items-center mx-auto max-w-7xl p-9 gap-x-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                    <SvgLoader class="shrink-0 fill-white" name="quote" />
                </div>
                <h2 class="text-2xl font-bold text-white">{{ $t('testimonials') }}</h2>
            </div>
        </div>

        <!-- Carousel -->
        <div v-if="0 < testimonials.length" class="relative overflow-hidden bg-gray-50">
            <div class="flex items-center max-w-5xl mx-auto mt-12 mb-8 p-9 gap-x-4">
                <carousel class="w-full" :items-to-show="1" :autoplay="4000" :pauseAutoplayOnHover="true" :wrapAround="true"
                    :transition="300">
                    <slide v-for="(testimonial, index) in testimonials" :key="index" class="flex flex-col">
                        <p class="text-2xl font-medium text-gray-900">
                            &ldquo;{{ testimonial.content }}&rdquo;
                        </p>

                        <p class="mt-6">
                            <span class="text-base font-medium text-gray-900 ">{{ testimonial.name }} / </span>
                            <span class="text-base font-medium text-gray-500 ">{{ testimonial.job }}, {{ testimonial.company
                            }}</span>
                        </p>
                    </slide>
                </carousel>
            </div>

            <div class="absolute hidden md:block -bottom-32 -left-16">
                <SvgLoader class="shrink-0 fill-gray-200" name="dotted_square" />
            </div>
        </div>

        <!-- Articles -->
        <div v-if="0 < articles.length" class="relative mb-10 overflow-hidden pb-9">

            <div class="pt-12 pb-20 bg-primary-500">
                <div class="flex items-center gap-4 mx-auto px-9 max-w-7xl">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-100">
                        <SvgLoader class="shrink-0 stroke-white fill-primary-100" name="sound" />
                    </div>
                    <h3 class="text-2xl font-bold text-white">{{ $t('related_articles') }}</h3>
                </div>
            </div>

            <div class="bg-white px-9">
                <ul role="list"
                    class="grid grid-cols-1 gap-8 mx-auto -mt-12 lg:mt-0 max-w-7xl sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                    <ArticleCard v-for="article in articles" :key="article.id" :data="article"
                        class="relative z-50 lg:-mt-12" />
                </ul>
            </div>

            <div class="absolute top-0 right-0 z-10 hidden lg:block">
                <SvgLoader class="shrink-0" name="squer_half_color" />
            </div>
        </div>

        <!-- External links -->
        <div v-if="0 < links.length" class="mx-auto max-w-7xl p-9 gap-x-4">
            <div class="flex items-center mx-auto mb-10 max-w-7xl gap-x-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                    <SvgLoader class="shrink-0 fill-primary-500" name="links" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $t('external_links_title') }}</h2>
            </div>

            <div class="border-l-8 border-primary-500">
                <div v-for="(link, index) in links" :key="index" class="ml-4">
                    <a class="text-base font-medium text-blue-500" :href="link.href" target="_blank">
                        <span class="underline">{{ link.label }}</span> <span class="text-gray-900">- {{ link.source
                        }}</span>
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
                    v-for="(edition, index) in editions" :key="index" class="text-xl font-bold text-blue-500"
                    :href="route('edition', edition.id)"
                >
                    {{ edition.name }}
                </Link>
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
    /** Import from vue */
    import {onMounted, ref} from 'vue';

    /** Import from inertia. */
    import { Head, Link, useForm, router } from '@inertiajs/vue3';

    /** Import plugins */
    import 'vue3-carousel/dist/carousel.css';
    import { Carousel, Slide } from 'vue3-carousel';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import PaginatedGrid from '@/Components/templates/PaginatedGrid.vue';
    import Sort from '@/Components/filters/Sort.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import SearchFilter from '@/Components/filters/SearchFilter.vue';
    import Input from '@/Components/form/Input.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import Modal from '@/Components/modals/Modal.vue';
    import ArticleCard from '@/Components/cards/ArticleCard.vue';
    import Select from '@/Components/form/Select.vue';
    import ChampionshipModal from '@/Components/modals/ChampionshipModal.vue';
    import ProjectSummaryCard from '@/Components/cards/ProjectSummaryCard.vue';

    const about_championship = 'Purus morbi dignissim senectus mattis adipiscing. Amet, massa quam varius orci dapibus volutpat cras. In amet eu ridiculus leo sodales cursus tristique. Tincidunt sed tempus ut viverra ridiculus non molestie. Gravida quis fringilla amet eget dui tempor dignissim. Facilisis auctor venenatis varius nunc, congue erat ac. Cras fermentum convallis quam.'

    /** Component props. */
    const props = defineProps({
        projects: Object,
        projectAmount: Number,
        projectDonationsNumber: Number,
        ongProjects: Array,
        championship: Object,
        testimonials: Array,
        editions: Array,
        links: Array,
        articles: Array,
        infinite_projects: Object,
    });

    /** Active filter state. */
    const hasValues = ref(false);

    /** Filter values. */
    const filter = ref({
        stage: 'Etapa curenta',
        sort: '',
        s: '',
    });

    onMounted(() => {
     console.log(props);
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
        from: 'championship-page',
    });

    /** Submit action. */
    const submit = () => {

        form.post(route('login'), {
            onFinish: () => form.reset('password'),
        });
    };

    const name = ref('')
    const test = (project) => {
        const form = useForm({
            championship_id: props.championship.id,
            project_id: project.id,
            stage_id : props.championship.active_stage.id,
        });

        name.value = project.name

        axios.post(route('championship.subscribe.project'), form.data()).then(
            (response) => {
                console.log(response)
                document.getElementById('championship-modal').click()
                document.getElementById('championship-success').click()
            },
            (error) => {
                console.log(error)
            }
        );
    }

    const closeSucces = (() => document.getElementById('championship-success').click())

    const stages = ['Etapa curenta', 'Etapa precendenta'];

    const page = ref(1);
    const infiniteProjects = ref([]);
    const loading = ref(false)
    const hasReachedEnd = ref(false);
    const infiniteScroll = async () => {
        loading.value = true

        try {
            const response = await fetch(route(`infinite_projects`, { page: page.value }));
            const data = await response.json();

            if (data) {
                infiniteProjects.value.push(...data);
                page.value++
                hasReachedEnd.value = false;
            }
        } catch (error) {
            console.error(error);
        } finally {
            loading.value = false
        }
    }

    const infiniteAtScroll = () => {
        const container = document.getElementById('parent');
        let triggerFetch = container.scrollTop >= (container.scrollHeight - container.clientHeight - 100);

        if (!hasReachedEnd.value && triggerFetch) {
            infiniteScroll()
            hasReachedEnd.value = true;
        }
    }

    const scrollTo = (section) => {
        const element = document.querySelector(section);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        }
    }
</script>
