<template>
    <PageLayout :title="$t('projects_title')" :icon="ViewBoardsIcon">
        <div v-if="view === 'map'" class="container">
            <Map :data="mapProjects" @county-selected="(id) => applySelectedCountyFromMap(id)" />
        </div>
        <div class="container grid items-start gap-6 md:grid-cols-12">
            <div class="flex gap-x-6 md:col-span-12 lg:col-span-5">
                <SearchFilter
                    v-model="filter.search"
                    :placeholder="$t('search')"
                    @keydown.enter="applyFilters"
                    class="flex-1"
                />

                <SecondaryButton @click="applyFilters">
                    {{ $t('search') }}
                </SecondaryButton>
            </div>

            <div class="flex gap-6 md:col-span-6 lg:col-span-3 whitespace-nowrap">
                <SecondaryButton
                    @click="clearFilters"
                    class="flex items-center justify-center gap-x-1.5 w-full md:w-auto"
                >
                    <XIcon class="-ml-0.5 h-4 w-4" aria-hidden="true" />
                    <span v-text="$t('empty_filters')" />
                </SecondaryButton>

                <Sort class="w-full md:w-auto" :sort="collection.sort" />
            </div>

            <div class="flex flex-col justify-end gap-6 md:col-span-6 lg:col-span-4 md:flex-row">
                <Link
                    :href="route('projects.index')"
                    class="flex items-center gap-2 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm"
                    :class="{
                        'text-white bg-primary-500 hover:bg-primary-400': view === 'list',
                        'text-gray-900 bg-white ring-1 ring-inset ring-gray-300 hover:bg-gray-50': view !== 'list',
                    }"
                >
                    <ViewGridIcon class="w-5 h-5 shrink-0" />
                    <span v-text="$t('projects_list')" />
                </Link>

                <Link
                    :href="route('projects.map')"
                    class="flex items-center gap-2 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm"
                    :class="{
                        'text-white bg-primary-500 hover:bg-primary-400': view === 'map',
                        'text-gray-900 bg-white ring-1 ring-inset ring-gray-300 hover:bg-gray-50': view !== 'map',
                    }"
                >
                    <LocationMarkerIcon class="w-5 h-5 shrink-0" />
                    <span v-text="$t('projects_map')" />
                </Link>
            </div>

            <Select
                class="relative md:col-span-6 lg:col-span-3"
                :label="$t('status')"
                v-model="filter.status"
                :options="{
                    active: $t('active'),
                    inactive: $t('inactive'),
                }"
                @update:modelValue="applyFilters"
            />

            <Select
                class="relative md:col-span-6 lg:col-span-3"
                :label="$t('county')"
                v-model="filter.county"
                :options="counties"
                type="object"
                @update:modelValue="applyFilters"
                multiple
            />

            <Select
                class="relative md:col-span-6 lg:col-span-3"
                :label="$t('project_categories')"
                v-model="filter.category"
                :options="categories"
                type="singleValue"
                @update:modelValue="applyFilters"
                multiple
            />

            <DatePicker
                :label="$t('donation_period')"
                class="md:col-span-6 lg:col-span-3"
                v-model="filter.date"
                @update:modelValue="applyFilters"
                range
            />
        </div>

        <div class="container">
            <h2
                class="mb-6 text-2xl font-bold text-gray-900"
                ref="projectsView"
                v-text="collection.meta.total + ' ' + $t('of_projects')"
            />

            <!-- Published projects -->
            <PaginatedGrid
                type="project"
                cardType="client"
                :list="collection"
                classes="grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3"
            />
        </div>
    </PageLayout>
</template>

<script setup>
import { ref } from 'vue';
import { ViewBoardsIcon, ViewGridIcon, LocationMarkerIcon, XIcon } from '@heroicons/vue/solid';
import route from '@/Helpers/useRoute';
import PageLayout from '@/Layouts/PageLayout.vue';
import Sort from '@/Components/filters/Sort.vue';
import SearchFilter from '@/Components/filters/SearchFilter.vue';
import PaginatedGrid from '@/Components/templates/PaginatedGrid.vue';
import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
import Map from '@/Components/maps/Map.vue';
import DatePicker from '@/Components/form/DatePicker.vue';
import Select from '@/Components/form/Select.vue';
import useFilters from '@/Helpers/useFilters.js';

const props = defineProps({
    collection: {
        type: Object,
    },
    counties: {
        type: Array,
    },
    categories: {
        type: Array,
    },
    mapProjects: {
        type: Array,
    },
    view: {
        type: String,
        default: 'list',
        validator: (view) => ['list', 'map'].includes(view),
    },
});

const filter = ref({
    county: props.collection.filter?.county || [],
    status: props.collection.filter?.status || null,
    category: props.collection.filter?.category || [],
    date: props.collection.filter?.date || [],
    search: props.collection.filter?.search || null,
});

let url = route(props.view === 'map' ? 'projects.map' : 'projects.index');
const projectsView = ref(null); // assigned to some element in the template

function applySelectedCountyFromMap(id) {
    filter.value.county.push(id);
    projectsView.value.scrollIntoView();
    applyFilters();
}

const { applyFilters, clearFilters } = useFilters(filter, props.collection.sort, url);
</script>
