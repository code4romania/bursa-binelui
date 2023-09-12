<template>
    <DashboardLayout>
        <Title :title="$t('donations')" :icon="CurrencyEuroIcon" />

        <!-- Filters -->

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
                :label="$t('amount')"
                v-model="filter.amount"
                :options="amounts"
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
                :label="$t('start_date')"
                v-model="filter.start_date"
                :options="start_dates"
                @update:modelValue="applyFilters"
            />

            <Select
                class="col-span-12 sm:col-span-6 lg:col-span-4"
                :label="$t('start_date')"
                v-model="filter.end_date"
                :options="end_dates"
                @update:modelValue="applyFilters"
            />
        </div>

        <Table :collection="collection" />
    </DashboardLayout>
</template>

<script setup>
    import { ref } from 'vue';
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

    const props = defineProps({
        collection: {
            type: Object,
            required: true,
        },
        filter: {
            type: Object,
            required: false,
        },
        //     projects: Array,
        //     statuses: Array,
        //     amounts: Array,
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
        start_date: props.filter?.start_date || null,
        end_date: props.filter?.end_date || null,
    });

    /** Statuses */
    const statuses = ['Active', 'Inactive'];
    const projects = ['Project 1', 'Project 2', 'Project 3'];
    const amounts = ['0 - 500', '500 - 1000', '1000 - 2000'];
    const start_dates = ['2023-05-17', '2023-06-07', '2023-03-19'];
    const end_dates = ['2023-05-17', '2023-06-07', '2023-03-19'];

    const sort = ref(null);

    const { applyFilters, clearFilters } = useFilters(filter, sort, route('dashboard.donations.index'));
</script>