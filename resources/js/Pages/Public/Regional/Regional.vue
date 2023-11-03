<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('regional_title')" />

        <!-- Header -->
        <div class="flex flex-col-reverse w-full gap-10 mx-auto lg:my-10 lg:flex-row lg:max-w-7xl sm:mt-0 px-9">
            <div class="relative flex flex-col w-full lg:w-6/12">
                <h1 class="relative z-50 py-6 text-3xl font-extrabold text-gray-900 lg:py-12 lg:text-6xl">
                    {{ $t('regional_title') }}
                </h1>

                <p class="my-6 text-base text-gray-500 lg:hidden lg:mb-0">{{ $t('competition') }}</p>

                <div class="flex flex-col w-full gap-4 mb-6 lg:mb-0 sm:flex-row">
                    <!-- Register -->
                    <Modal
                        v-if="!$page.props.auth.user"
                        triggerModalClasses="bg-primary-500 w-full sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        :triggerModalText="$t('register_project')"
                    >
                        <form class="mt-6 space-y-6" @submit.prevent="submit">
                            <h3 class="text-lg font-semibold text-center text-gray-900">
                                Intră în contul organizației tale pentru a inscrie un proiect
                            </h3>
                            <p class="text-base text-center text-gray-500">
                                Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim.
                            </p>

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
                                    type="submit"
                                    class="w-full"
                                    :disabled="form.processing"
                                    :label="$t('log_in')"
                                />

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
                                    {{ $t('no_account') }} <span class="text-primary-500">{{ $t('register') }}</span>
                                </Link>
                            </div>
                        </form>
                    </Modal>

                    <!-- Add Project -->
                    <ChampionshipModal v-if="$page.props.auth.user">
                        <div class="px-9">
                            <Link
                                :href="route('dashboard.projects.regional.create')"
                                class="flex w-fit items-center gap-x-2 py-2.5 my-10 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            >
                                <SvgLoader name="add" />
                                {{ $t('add_new_project') }}
                            </Link>
                        </div>

                        <div
                            v-if="query.data.length"
                            class="grid grid-cols-1 mb-4 overflow-y-auto gap-x-8 gap-y-12 px-9 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 max-h-128"
                        >
                            <ProjectSummaryCard v-for="data in query.data" :data="data" @choosed="test" />
                        </div>
                    </ChampionshipModal>

                    <Modal
                        id="championship-success"
                        triggerModalClasses="hidden bg-primary-500 w-full sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        :triggerModalText="$t('register_project')"
                    >
                        <div class="flex flex-col items-center w-full my-4 space-y-3">
                            <SvgLoader name="success" class="fill-green-200" />

                            <h3 class="text-lg font-bold text-gray-500">{{ $t('championship_success_title') }}</h3>

                            <p class="text-lg font-bold text-primary-500">{{ name }}</p>

                            <p class="text-sm text-center text-gray-500">
                                {{ $t('championship_success_description') }}
                            </p>

                            <div class="flex items-center w-full gap-4">
                                <SecondaryButton
                                    class="flex items-center justify-center mt-6 flex-1 gap-x-2 py-2.5"
                                    @click="closeSucces"
                                >
                                    {{ $t('close') }}
                                </SecondaryButton>

                                <Link
                                    href="#"
                                    class="bg-primary-500 flex-1 text-center mt-6 sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                                >
                                    {{ $t('championship_rules') }}
                                </Link>
                            </div>
                        </div>
                    </Modal>
                </div>

                <LargeSquarePattern class="absolute hidden md:block -top-24 -left-32 fill-primary-300" />
            </div>

            <div class="relative items-center justify-center w-full lg:px-20 lg:pb-9 lg:w-6/12 sm:flex">
                <LargeSquarePattern class="absolute bottom-0 right-0 hidden md:block fill-primary-500" />

                <div class="relative flex items-center bg-white rounded shadow w-fit">
                    <img class="mx-auto rounded-lg" src="/images/auth_image.jpg" alt="" />

                    <div
                        class="absolute flex items-center justify-center w-32 h-32 rounded-lg bg-gray-50 -bottom-10 -left-10"
                    >
                        <SvgLoader class="shrink-0" name="location_big" />
                    </div>
                </div>
            </div>
        </div>

        <!-- About -->
        <div class="mx-auto mb-10 max-w-7xl p-9 md:flex-row">
            <h3 class="mb-6 text-3xl font-bold text-cyan-900">{{ $t('about_regional') }}</h3>
            <div class="text-base font-normal text-gray-500" v-html="about_championship"></div>
        </div>

        <!-- Curent year -->
        <div class="relative mb-10 overflow-hidden pb-9">
            <div class="pt-12 pb-20 bg-primary-500 px-9 lg:px-0">
                <div class="flex items-center gap-4 mx-auto max-w-7xl">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-100">
                        <SvgLoader class="shrink-0 stroke-white fill-primary-100" name="sound" />
                    </div>
                    <h3 class="text-2xl font-bold text-white">2022 - 2023</h3>
                </div>
            </div>

            <div class="relative -mt-12 bg-white">
                <ul
                    role="list"
                    class="grid grid-cols-1 gap-8 mx-auto max-w-7xl sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3"
                >
                    <EditionCard
                        v-for="edition in regions"
                        :key="edition.id"
                        :data="edition"
                        class="relative z-50"
                        :urlRoute="route('regional.edition.region', edition.id)"
                    />
                </ul>

                <LargeSquarePattern class="absolute top-0 right-0 z-10 hidden lg:block fill-primary-200" />
            </div>
        </div>

        <!-- Last year -->
        <div class="relative mb-10 overflow-hidden pb-9">
            <div class="pt-12 pb-20 bg-primary-500 px-9 lg:px-0">
                <div class="flex items-center gap-4 mx-auto max-w-7xl">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-100">
                        <SvgLoader class="shrink-0 stroke-white fill-primary-100" name="sound" />
                    </div>
                    <h3 class="text-2xl font-bold text-white">2021 - 2022</h3>
                </div>
            </div>

            <div class="relative -mt-12 bg-white">
                <ul
                    role="list"
                    class="grid grid-cols-1 gap-8 mx-auto max-w-7xl sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3"
                >
                    <EditionCard
                        v-for="edition in regions"
                        :key="edition.id"
                        :data="edition"
                        class="relative z-50"
                        :urlRoute="route('regional.edition.region', edition.id)"
                    />
                </ul>

                <LargeSquarePattern class="absolute top-0 right-0 z-10 hidden lg:block fill-primary-200" />
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
    /** Import from vue */
    import { ref } from 'vue';
    import route from '@/Helpers/useRoute';

    /** Import from inertia. */
    import { Head, Link, useForm, router } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Icon from '@/Components/Icon.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Input from '@/Components/form/Input.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import Modal from '@/Components/modals/Modal.vue';
    import ArticleCard from '@/Components/cards/ArticleCard.vue';
    import ChampionshipModal from '@/Components/modals/ChampionshipModal.vue';
    import ProjectSummaryCard from '@/Components/cards/ProjectSummaryCard.vue';
    import EditionCard from '@/Components/cards/Edition.vue';

    import LargeSquarePattern from '@/Components/patterns/LargeSquarePattern.vue';

    const about_championship =
        'Purus morbi dignissim senectus mattis adipiscing. Amet, massa quam varius orci dapibus volutpat cras. In amet eu ridiculus leo sodales cursus tristique. Tincidunt sed tempus ut viverra ridiculus non molestie. Gravida quis fringilla amet eget dui tempor dignissim. Facilisis auctor venenatis varius nunc, congue erat ac. Cras fermentum convallis quam.';

    /** Component props. */
    const props = defineProps({
        query: Object,
        championship: Object,
        editions: Array,
        registration: Object,
        parteners: Array,
        faqs: Array,
        countries: Array,
        regions: Array,
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
