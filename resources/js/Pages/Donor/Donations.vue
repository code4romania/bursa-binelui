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
    import Title from '@/Components/Title.vue';
    import Table from '@/Components/tables/Table.vue';
    import Select from '@/Components/form/Select.vue';
    import SearchFilter from '@/Components/filters/SearchFilter.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import useFilters from '@/Helpers/useFilters.js';
    import PageLayout from '@/Layouts/PageLayout.vue';
    import { XIcon } from '@heroicons/vue/solid';

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
