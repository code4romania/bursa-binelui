<template>
    <PageLayout :title="$t('projects_title')" icon="list">
        <!-- Filters -->
        <div class="container grid items-start gap-6 sm:grid-cols-12">
            <div class="flex gap-x-6 sm:col-span-5">
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

            <div class="flex gap-6 sm:col-span-3">
                <SecondaryButton @click="clearFilters" class="flex items-center gap-x-1.5 w-full sm:w-auto">
                    <XIcon class="-ml-0.5 h-4 w-4" aria-hidden="true" />
                    <span v-text="$t('empty_filters')" />
                </SecondaryButton>

                <Sort class="w-full sm:w-auto" />
            </div>

            <div class="flex flex-col justify-end gap-6 sm:col-span-4 sm:flex-row">
                <Link
                    :href="route('projects')"
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
                class="relative sm:col-span-12 md:col-span-6 lg:col-span-3"
                :label="$t('status')"
                v-model="filter.status"
                :options="{
                    active: $t('active'),
                    inactive: $t('inactive'),
                }"
                @update:modelValue="applyFilters"
            />

            <Select
                class="relative sm:col-span-12 md:col-span-6 lg:col-span-3"
                :label="$t('county')"
                v-model="filter.county"
                :options="counties"
                type="object"
                @update:modelValue="applyFilters"
                multiple
            />

            <Select
                class="relative sm:col-span-12 md:col-span-6 lg:col-span-3"
                :label="$t('project_categories')"
                v-model="filter.category"
                :options="categories"
                type="singleValue"
                @update:modelValue="applyFilters"
                multiple
            />

            <DatePicker
                :label="$t('donation_period')"
                class="sm:col-span-12 md:col-span-6 lg:col-span-3"
                v-model="filter.date"
                @update:modelValue="applyFilters"
                range
            />
        </div>

        <div v-if="view === 'map'" class="container">
            <Map :data="projectsForMap" />
        </div>

        <div class="container">
            <h2 class="mb-6 text-2xl font-bold text-gray-900">{{ resource.meta.total }} {{ $t('of_projects') }}</h2>

            <!-- Published projects -->
            <PaginatedGrid
                type="project"
                cardType="client"
                :list="resource"
                classes="grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3"
            />
        </div>
    </PageLayout>
</template>

<script setup>
    import { ref } from 'vue';
    import { ViewGridIcon, LocationMarkerIcon, XIcon } from '@heroicons/vue/solid';
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Sort from '@/Components/filters/Sort.vue';
    import SearchFilter from '@/Components/filters/SearchFilter.vue';
    import PaginatedGrid from '@/Components/templates/PaginatedGrid.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import Map from '@/Components/maps/Map.vue';
    import DatePicker from '@/Components/form/DatePicker.vue';
    import SelectMultiple from '@/Components/form/SelectMultiple.vue';
    import Select from '@/Components/form/Select.vue';
    import useFilters from '@/Helpers/useFilters.js';

    const props = defineProps({
        resource: {
            type: Object,
        },
        counties: {
            type: Array,
        },
        categories: {
            type: Array,
        },
        view: {
            type: String,
            default: 'list',
            validator: (view) => ['list', 'map'].includes(view),
        },
        filter: {
            type: Object,
            required: false,
        },
    });

    const filter = ref({
        county: props.filter?.county || [],
        status: props.filter?.status || null,
        category: props.filter?.category || [],
        date: props.filter?.date || [],
        search: props.filter?.search || null,
    });

    const sort = ref(null);

    const url = route(props.view === 'map' ? 'projects.map' : 'projects');

    const { applyFilters, clearFilters } = useFilters(filter, sort, url);
</script>
