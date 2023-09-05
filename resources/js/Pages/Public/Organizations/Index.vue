<template>
    <PageLayout :title="$t('organization_title')" icon="list">
        <!-- Filters -->
        <div class="container">
            <div class="flex w-full gap-6 mt-6">
                <SearchFilter v-model="filter.s" :placeholder="$t('search')" @keydown.enter="filterOrganizations" />

                <SecondaryButton @click="filterOrganizations" class="p-0">
                    {{ $t('search') }}
                </SecondaryButton>

                <SecondaryButton @click="emptyFilters" class="flex items-center gap-2 py-0">
                    <SvgLoader name="close" />
                    {{ $t('empty_filters') }}
                </SecondaryButton>
            </div>

            <div class="flex w-full gap-6 mt-6">
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
                    :label="$t('county')"
                    v-model="filter.c"
                    :options="counties"
                    type="object"
                    @callback="filterOrganizations"
                />
            </div>
        </div>

        <div class="container">
            <h2 class="my-6 text-3xl font-bold text-gray-900">
                {{ query.meta.total }} {{ 1 >= parseInt(query.meta.total) ? $t('organization') : $t('organizations') }}
            </h2>

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
    import { ref, watch, onMounted } from 'vue';

    /** Import from inertia. */
    import { Head, router, usePage } from '@inertiajs/vue3';

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
        request: [Array, Object],
    });

    /** Active filter state. */
    const hasValues = ref(false);

    /** Filter values. */
    const filter = ref({
        ad: [],
        c: [],
        s: '',
    });

    /** Filter organizations. */
    const filterOrganizations = () => {
        let query = {};

        if (filter.value.ad.length) {
            query.ad = filter.value.ad.map((domain) => domain.id).join(',');
        }

        if (filter.value.c.length) {
            query.c = filter.value.c.map((domain) => domain.id).join(',');
        }

        if (filter.value.s.length) {
            query.s = filter.value.s;
        }

        router.get(route('organizations'), {
            filter: query,
        });
    };

    /** Empty filters. */
    const emptyFilters = () => {
        router.visit(route('organizations'));
    };
</script>
