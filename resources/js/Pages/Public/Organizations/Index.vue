<template>
    <PageLayout :title="$t('organization_title')" icon="list">
        <!-- Filters -->
        <div class="container grid items-start gap-6 sm:grid-cols-6">
            <div class="flex gap-x-6 sm:col-span-3">
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

            <div class="sm:col-span-3">
                <SecondaryButton @click="clearFilters" class="flex items-center gap-x-1.5">
                    <XIcon class="-ml-0.5 h-4 w-4" aria-hidden="true" />
                    <span v-text="$t('empty_filters')" />
                </SecondaryButton>
            </div>

            <Select
                :label="$t('domains')"
                v-model="filter.domain"
                @update:modelValue="applyFilters"
                :options="domains"
                class="sm:col-span-2"
                multiple
            />

            <Select
                :label="$t('county')"
                v-model="filter.county"
                @update:modelValue="applyFilters"
                :options="counties"
                class="sm:col-span-2"
                multiple
            />

            <Select
                :label="$t('organization_accepts_volunteers')"
                v-model="filter.volunteers"
                @update:modelValue="applyFilters"
                class="sm:col-span-2"
                :options="[
                    {
                        value: 1,
                        label: $t('yes'),
                    },
                    {
                        value: 0,
                        label: $t('no'),
                    },
                ]"
            />
        </div>

        <div class="container">
            <h2 class="my-6 text-4xl font-bold text-gray-900">
                {{ resource.meta.total }}
                {{ 1 >= parseInt(resource.meta.total) ? $t('organization') : $t('organizations') }}
            </h2>

            <!-- List -->
            <PaginatedGrid
                type="ong"
                :list="resource"
                classes="mt-6 grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3"
            />
        </div>
    </PageLayout>
</template>

<script setup>
    import { ref } from 'vue';
    import { router } from '@inertiajs/vue3';
    import { XIcon } from '@heroicons/vue/solid';

    import PageLayout from '@/Layouts/PageLayout.vue';
    import PaginatedGrid from '@/Components/templates/PaginatedGrid.vue';
    import SearchFilter from '@/Components/filters/SearchFilter.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import Select from '@/Components/form/Select.vue';
    import useFilters from '@/Helpers/useFilters.js';

    const props = defineProps({
        resource: {
            type: Object,
            required: true,
        },
        counties: {
            type: Array,
            default: () => [],
        },
        domains: {
            type: Array,
            default: () => [],
        },
        filter: {
            type: Object,
            required: false,
        },
    });

    const filter = ref({
        county: props.filter?.county || [],
        domain: props.filter?.domain || [],
        volunteers: props.filter?.volunteers || null,
        search: props.filter?.search || null,
    });

    const sort = ref(null);

    const { applyFilters, clearFilters } = useFilters(filter, sort, route('organizations.index'));
</script>
