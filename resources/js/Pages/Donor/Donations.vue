<template>
    <PageLayout>
        <div class="mx-auto my-10 space-y-10 max-w-7xl">
            <!-- Header -->
            <Title :title="$t('my_donations')" />
            <div class="grid grid-cols-12 gap-6">
                <div class="grid grid-cols-12 col-span-12 gap-6">
                    <SearchFilter
                        class="col-span-4"
                        v-model="filter.search"
                        :placeholder="$t('search')"
                        @keydown.enter="applyFilters"
                    />

                    <SecondaryButton @click="applyFilters" class="col-span-2 py-2 text-center">
                        {{ $t('search') }}
                    </SecondaryButton>

                    <SecondaryButton
                        v-if="hasValues"
                        @click="clearFilters"
                        class="flex items-center justify-center col-span-2 gap-2 py-2 text-center"
                    >
                        <SvgLoader name="close" />
                        {{ $t('empty_filters') }}
                    </SecondaryButton>

                    <div :class="['col-span-12 flex justify-end', hasValues ? 'sm:col-span-4' : 'sm:col-span-6']">
                        <SecondaryButton class="flex items-center justify-center gap-4 py-2">
                            <SvgLoader class="shrink-0" name="download" />
                            {{ $t('download_table') }}
                        </SecondaryButton>
                    </div>
                </div>

                <Select
                    class="col-span-12 sm:col-span-6 lg:col-span-4"
                    :label="$t('donation_status')"
                    v-model="filter.status"
                    :options="statuses"
                    @update:modelValue="applyFilters"
                />

                <Select
                    class="col-span-12 sm:col-span-6 lg:col-span-4"
                    :label="$t('project')"
                    v-model="filter.project"
                    :options="projects"
                    @update:modelValue="applyFilters"
                />
                <Select
                    class="col-span-12 sm:col-span-6 lg:col-span-4"
                    :label="$t('organization')"
                    v-model="filter.organization"
                    :options="organizations"
                    @update:modelValue="applyFilters"
                />

                <Select
                    class="col-span-12 sm:col-span-6 lg:col-span-4"
                    :label="$t('start_date')"
                    v-model="filter.start_date"
                    :options="dates"
                    @update:modelValue="applyFilters"
                />

                <Select
                    class="col-span-12 sm:col-span-6 lg:col-span-4"
                    :label="$t('start_date')"
                    v-model="filter.end_date"
                    :options="dates"
                    @update:modelValue="applyFilters"
                />
            </div>
            <Table :collection="collection" />
        </div>
    </PageLayout>
</template>

<script setup>
    import { ref } from 'vue';
    import route from '@/Helpers/useRoute';
    import { CurrencyEuroIcon } from '@heroicons/vue/outline';
    import DashboardLayout from '@/Layouts/DashboardLayout.vue';
    import Title from '@/Components/Title.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Table from '@/Components/tables/Table.vue';
    import Select from '@/Components/form/Select.vue';
    import SearchFilter from '@/Components/filters/SearchFilter.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import useFilters from '@/Helpers/useFilters.js';
    import { Head } from '@inertiajs/vue3';
    import PageLayout from '@/Layouts/PageLayout.vue';

    const props = defineProps({
        collection: {
            type: Object,
            required: true,
        },
        filter: {
            type: Object,
            required: false,
        },
        projects: Array,
        organizations: Array,
        statuses: Array,
        amounts: Array,
        dates: Array,
        //     start_dates: Array,
        //     end_dates: Array
    });

    /** Active filter state. */
    const hasValues = ref(false);

    /** Filter values. */
    const filter = ref({
        search: props.filter?.search || null,
        status: props.filter?.status || null,
        amount: props.filter?.amount || null,
        project: props.filter?.project || null,
        organization: props.filter?.organization || null,
        start_date: props.filter?.start_date || null,
        end_date: props.filter?.end_date || null,
    });

    const sort = ref(null);
    const { applyFilters, clearFilters } = useFilters(filter, sort, route('donor.donations'));
</script>
