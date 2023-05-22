<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('organization_title')" />

        <div class="p-9 mt-4 mx-auto max-w-7xl">

            <!-- Header -->
            <header class="flex items-center gap-4">
                <div class="bg-turqoise-500 w-8 h-8 rounded-lg flex items-center justify-center">
                    <SvgLoader class="shrink-0 fill-turqoise-500" name="brand"/>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $t('organization_title') }}</h2>
            </header>

            <!-- Filters -->
            <div class="flex w-full gap-6 mt-6">
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
                    v-if="hasValues"
                    @click="emptyFilters"
                    class="py-0 flex gap-2 items-center"
                >
                    <SvgLoader name="close" />
                    {{ $t('empty_filters') }}
                </SecondaryButton>
            </div>

            <div class="flex w-full gap-6 mt-6">
                <MultiSelectFilter
                    class="w-80"
                    :label="$t('domains')"
                    v-model="filter.ad"
                    :options="activity_domains"
                    id="activity-domains"
                    ref="activityDomains"
                    @callback="filterOrganizations"
                />

                <MultiSelectObjectFilter
                    class="w-80"
                    :label="$t('county_city')"
                    v-model="filter.c"
                    :options="cities"
                    id="counties"
                    ref="counties"
                    @callback="filterOrganizations"
                />
            </div>

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
    import { ref } from 'vue';

    /** Import from inertia. */
    import { Head, usePage, useForm, router } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import PaginatedGrid from '@/Components/templates/PaginatedGrid.vue';
    import SearchFilter from '@/Components/filters/SearchFilter.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import MultiSelectFilter from '@/Components/filters/MultiSelectFilter.vue';
    import MultiSelectObjectFilter from '@/Components/filters/MultiSelectObjectFilter.vue';

    /** Page props. */
    const props = defineProps({
        query: [Array, Object],
        activity_domains: [Array, Object],
        cities: [Array, Object],
        request: [Array, Object]
    });

    /** Active filter state. */
    const hasValues = ref(false);

    /** Filter values. */
    const filter = ref({
        ad: '',
        c: '',
        s: ''
    });

    /** Filter organizations. */
    const filterOrganizations = () => {
        router.visit(route('organizations'), {
            method: 'get',
            data: filter.value,
            preserveState: true,
            onSuccess: (data) => {
                if (Object.values(data.props.request).every(value => value === null)) {
                    hasValues.value = false
                } else {
                    hasValues.value = true
                }
            }
        })
    };

    /** Empty filters. */
    const emptyFilters = () => {
        router.visit(route('organizations'));
    };
</script>
