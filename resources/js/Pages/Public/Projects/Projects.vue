<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('projects_title')" />

        <div class="mx-auto mt-4 mb-24 p-9 max-w-7xl">

            <!-- Header -->
            <header class="flex items-center gap-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-turqoise-500">
                    <SvgLoader class="shrink-0 fill-turqoise-500" name="list"/>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $t('projects_title') }}</h2>
            </header>

            <!-- Filters -->
            <div class="my-11">
                <div class="flex flex-col w-full sm:flex-row">
                    <div class="flex flex-col items-center w-full gap-6 sm:flex-row xl:w-8/12">

                        <!-- Search -->
                        <div class="flex gap-6">
                            <SearchFilter
                                id="project-search"
                                class="w-full"
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
                            <Sort class="w-1/2 sm:w-auto" />
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="flex flex-col justify-end gap-6 xl:w-4/12 sm:flex-row">
                        <Link
                            :href="route('projects')"
                            class="flex items-center gap-x-4 bg-turqoise-500 hover:bg-turqoise-400 text-white rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm"
                        >
                            <SvgLoader class="shrink-0" name="grid"/>
                            {{ $t('projects_list') }}
                        </Link>

                        <Link
                            :href="route('projects')"
                            class="flex items-center gap-x-4 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 py-2.5"
                        >
                            <SvgLoader class="shrink-0" name="location"/>
                            {{ $t('projects_map') }}
                        </Link>
                    </div>
                </div>

                <div class="flex flex-col justify-between w-full gap-6 mt-6 sm:flex-row">

                    <Select
                        class="w-full"
                        :label="$t('status')"
                        v-model="filter.status"
                        :options="statuses"
                    />

                    <MultiSelectObjectFilter
                        class="w-full"
                        :label="$t('county_city')"
                        v-model="filter.c"
                        :options="props.counties"
                        @callback="filterProjects"
                    />

                    <!-- Date -->
                    <Input
                        class="w-full"
                        :label="$t('period')"
                        color="gray-700"
                        id="project-name"
                        type="date"
                        v-model="filter.period"
                    />
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-900">{{ props.query.total }} {{ $t('of_projects') }}</h2>

            <!-- Published projects -->
            <PaginatedGrid
                type="project"
                cardType="client"
                :list="props.query"
                classes="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 mb-4"
            />
        </div>
    </PageLayout>
</template>

<script setup>
    /** Import from vue. */
    import { ref } from 'vue';

    /** Import from inertia. */
    import { Head, Link, router } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Sort from '@/Components/filters/Sort.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Input from '@/Components/form/Input.vue';
    import Select from '@/Components/form/Select.vue';
    import SearchFilter from '@/Components/filters/SearchFilter.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import PaginatedGrid from '@/Components/templates/PaginatedGrid.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import MultiSelectObjectFilter from '@/Components/filters/MultiSelectObjectFilter.vue';

    /** Active filter state. */
    const hasValues = ref(false);

    /** Filter values. */
    const filter = ref({
        ad: '',
        c: '',
        s: '',
        status:'',
        period: ''
    });

    /** Statuses */
    const statuses = ['Active', 'Inactive'];
    const cities = [{}];

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
        router.visit(route('projects'))
    };
    const props = defineProps({
        query: {
            type: Object,
        },
        counties: {
            type: Array,
        },
    });
</script>
