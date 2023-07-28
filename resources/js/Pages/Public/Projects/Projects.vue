<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('projects_title')" />

        <div class="mx-auto mt-4 mb-24 p-9 max-w-7xl">

            <!-- Header -->
            <header class="flex items-center gap-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                    <SvgLoader class="shrink-0 fill-primary-500" name="list"/>
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
                                class="w-full z-101"
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
                            <Sort class="w-full md:w-auto z-103" />
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="flex flex-col justify-end gap-6 xl:w-4/12 sm:flex-row">
                        <button
                            @click="viewType='list';filter.c=null"
                            :href="route('projects')"
                            :class="[
                                'list' === viewType ?
                                'flex items-center gap-x-4 bg-primary-500 hover:bg-primary-400 text-white rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm' :
                                'flex items-center gap-x-4 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 py-2.5'
                            ]"
                        >
                            <SvgLoader class="shrink-0" name="grid"/>
                            {{ $t('projects_list') }}
                        </button>

                        <button
                            @click="viewType='map';filter.c=null"
                            :href="route('projects')"
                            :class="[
                                'map' === viewType ?
                                'flex items-center gap-x-4 bg-primary-500 hover:bg-primary-400 text-white rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm' :
                                'flex items-center gap-x-4 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 py-2.5'
                            ]"
                        >
                            <SvgLoader class="shrink-0" name="location"/>
                            {{ $t('projects_map') }}
                        </button>
                    </div>
                </div>

                <div v-if="'list' === viewType" class="grid grid-cols-12 gap-6 mt-6">

                    <Select
                        class="relative col-span-12 md:col-span-6 lg:col-span-3 z-102"
                        :label="$t('status')"
                        v-model="filter.status"
                        :options="statuses"
                        @callback="filterProjects"
                    />

                    <SelectMultiple
                        class="relative col-span-12 md:col-span-6 lg:col-span-3 z-101"
                        :label="$t('county_city')"
                        v-model="filter.counties"
                        :options="props.counties"
                        type="object"
                        @callback="filterProjects"
                    />

                    <SelectMultiple
                        class="relative col-span-12 md:col-span-6 lg:col-span-3 z-100"
                        :label="$t('project_categories')"
                        v-model="filter.categories"
                        :options="domains"
                        type="singleValue"
                        @callback="filterProjects"
                    />

                    <DatePeriod
                        :label="$t('donation_period')"
                        class="col-span-12 md:col-span-6 lg:col-span-3"
                        id="dateperiod"
                        v-model="filter.date"
                    />
                </div>
            </div>

            <Map
                v-if="'map' === viewType"
                :data="projectsForMap"
                @countySelected="filter.c = $event"
                class="mb-6"
            />

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
    import {ref, watch,computed} from 'vue';

    /** Import from inertia. */
    import { Head, Link, router } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Sort from '@/Components/filters/Sort.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import SearchFilter from '@/Components/filters/SearchFilter.vue';
    import PaginatedGrid from '@/Components/templates/PaginatedGrid.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import Map from '@/Components/maps/Map.vue'
    import DatePeriod from '@/Components/form/DatePeriod.vue';
    import SelectMultiple from '@/Components/form/SelectMultiple.vue';
    import Select from '@/Components/form/Select.vue';

    /** Active filter state. */
    const hasValues = ref(false);

    /** Filter values. */
    const filter = ref({
        counties: [],
        status: null,
        categories: [],
        date: ''
    });

    const projectsForMap = [
        {
            id: 1,
            name: 'Craiova',
            projects: 3,
            coordinates: { lat: 44.3304, lng: 23.7949 },
        },
        {
            id: 2,
            name: 'Bucuresti',
            projects: 30,
            coordinates: { lat: 44.4268, lng: 26.1025 },
        },
    ];

    /** Statuses */
    const statuses = ['Active', 'Inactive'];
    const cities = [{}];

    const viewType = ref('list');

    /** Filter projects. */
    const filterProjects = () => {

        if (0 < filter.value.counties.length) {
            filter.value.counties = filter.value.counties.map(county => parseInt(county.id))
        }

        router.visit(route('projects'), {
            method: 'get',
            data: filter.value,
            preserveState: true,
            onSuccess: (data) => {
                if (0 < filter.value.counties.length) {
                    filter.value.counties = props.counties.filter(county => props.counties.includes(county.id));
                }
                if (Object.values(filter.value).every(value => (value === null) || (value.length === 0))) {
                    hasValues.value = false
                } else {
                    hasValues.value = true
                }
            }
        })
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
        categories: {
            type: Array
        }
    });

    const domains = computed(() => props.categories.map((category) => category.name));

    // watch(filter, () => {
    //     filterProjects();
    // },{deep:true})
</script>
