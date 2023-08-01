<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('organization_title')" />

        <div class="mx-auto mt-4 p-9 max-w-7xl">

            <!-- Header -->
            <header class="flex items-center gap-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                    <SvgLoader class="shrink-0 fill-primary-500" name="brand"/>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $t('organization_title') }}</h2>
            </header>

            <div v-if="!showFilters" class="flex w-full gap-6 mt-6">
                <SecondaryButton
                    @click="showFilters = true"
                    class="flex items-center gap-2 py-2.5 px-3.5"
                >
                    <SvgLoader name="filtres" />
                    {{ $t('filters') }}
                </SecondaryButton>
            </div>

            <!-- Filters -->
            <div v-if="showFilters" class="flex w-full gap-6 mt-6">
                <SearchFilter
                    v-model="filter.s"
                    :placeholder="$t('search')"
                    @keydown.enter="filterOrganizations"
                />

                <SecondaryButton
                    @click="filterOrganizations"
                    class="p-0"
                >
                    {{ $t('search') }}
                </SecondaryButton>

                <SecondaryButton
                    v-if="showFilters"
                    @click="emptyFilters"
                    class="flex items-center gap-2 py-0"
                >
                    <SvgLoader name="close" />
                    {{ $t('empty_filters') }}
                </SecondaryButton>
            </div>

            <div v-if="showFilters" class="flex w-full gap-6 mt-6">

                <SelectMultiple
                    class="w-80"
                    :label="$t('domains')"
                    type="object"
                    v-model="filter.ad"
                    :options="activity_domains"
                    @callback="filterOrganizations"
                />

                <SelectMultiple
                    class="w-80"
                    :label="$t('county_city')"
                    v-model="filter.c"
                    :options="counties"
                    type="object"
                    @callback="filterOrganizations"
                />
            </div>

            <h3 class="my-6 text-3xl font-bold text-gray-900">{{ query.total }} {{ 1 >= parseInt(query.total) ? $t('organization') : $t('organizations') }}</h3>

            <!-- List -->
            <PaginatedGrid
                type="ong"
                :list="query"
                classes="mt-6 grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3"
            />
        </div>
    </PageLayout>
</template>

<script setup>
import { ref, watch ,onMounted} from 'vue';

/** Import from inertia. */
import { Head, router } from '@inertiajs/vue3';

/** Import components. */
import PageLayout from '@/Layouts/PageLayout.vue';
import SvgLoader from '@/Components/SvgLoader.vue';
import PaginatedGrid from '@/Components/templates/PaginatedGrid.vue';
import SearchFilter from '@/Components/filters/SearchFilter.vue';
import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
import MultiSelectObjectFilter from '@/Components/filters/MultiSelectObjectFilter.vue';
import SelectMultiple from '@/Components/form/SelectMultiple.vue';

/** Page props. */
const props = defineProps({
    query: [Array, Object],
    activity_domains: [Array, Object],
    counties: [Array, Object],
    request: [Array, Object]
});

/** Active filter state. */
const hasValues = ref(false);
const showFilters = ref(false);

/** Filter values. */
const filter = ref({
    ad: [],
    c: [],
    s: ''
});

/** Filter organizations. */
const filterOrganizations = () => {

    if (0 < filter.value.ad.length) {
        filter.value.ad = filter.value.ad.map(domain => domain.id)
    }

    if (0 < filter.value.c.length) {
        filter.value.c = filter.value.c.map(county => county.id)
    }

    router.visit(route('organizations'), {
        method: 'get',
        data: filter.value,
        preserveState: true,
        onSuccess: (data) => {

            if (0 < filter.value.ad.length) {
                filter.value.ad = props.activity_domains.filter(domain => filter.value.ad.includes(parseInt(domain.id)));
            }

            if (0 < filter.value.c.length) {
                filter.value.c = props.counties.map(county => filter.value.c.includes(parseInt(county.id)))
            }

            if (Object.values(data.props.request).every(value => value === null)) {
                hasValues.value = false
                showFilters.value = false
            } else {
                hasValues.value = true
                showFilters.value = true
            }
        }
    })
};

/** Empty filters. */
const emptyFilters = () => {
    router.visit(route('organizations'));
    showFilters.value = false
};
</script>
