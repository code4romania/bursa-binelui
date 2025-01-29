<template>
    <DashboardLayout>
        <Title :title="$t('donations')" :icon="CurrencyEuroIcon" />

        <!-- Filters -->
        <div class="grid grid-cols-12 gap-6">
            <div class="grid grid-cols-12 col-span-12 gap-3">
                <SearchFilter
                    class="col-span-2"
                    v-model="filter.search"
                    :placeholder="$t('search')"
                    @keydown.enter="applyFilters"
                />

                <SecondaryButton @click="applyFilters" class="col-span-2 py-2 text-center">
                    {{ $t('search') }}
                </SecondaryButton>

                <SecondaryButton
                    @click="clearFilters"
                    class="flex items-center justify-center col-span-2 py-2 text-center gap-x-2"
                >
                    <XIcon class="w-4 h-4 shrink-0" />

                    {{ $t('empty_filters') }}
                </SecondaryButton>
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
            <DatePicker
                :label="$t('donation_period')"
                class="md:col-span-6 lg:col-span-3"
                v-model="filter.dates"
                @update:modelValue="applyFilters"
                range
            />
        </div>

        <Table :collection="collection" />
    </DashboardLayout>
</template>

<script setup>
import { ref } from 'vue';
import route from '@/Helpers/useRoute';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Title from '@/Components/Title.vue';
import Table from '@/Components/tables/Table.vue';
import Select from '@/Components/form/Select.vue';
import SearchFilter from '@/Components/filters/SearchFilter.vue';
import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
import useFilters from '@/Helpers/useFilters.js';
import { CurrencyEuroIcon } from '@heroicons/vue/outline';
import { XIcon } from '@heroicons/vue/solid';
import DatePicker from '@/Components/form/DatePicker.vue';

const props = defineProps({
    collection: {
        type: Object,
        required: true,
    },
    filter: {
        type: Object,
        required: false,
    },
    projects: Object,
    statuses: Object,
    dates: Array,
});

/** Active filter state. */
const hasValues = ref(false);

/** Filter values. */
const filter = ref({
    search: props.filter?.search || null,
    status: props.filter?.status || null,
    amount: props.filter?.amount || null,
    project: props.filter?.project || null,
    dates: props.filter?.dates || [],
});

const sort = ref(null);

const { applyFilters, clearFilters } = useFilters(filter, sort, route('dashboard.donations.index'));
</script>
