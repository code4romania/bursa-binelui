<template>
    <thead>
        <tr>
            <th
                v-for="(column, index) in columns"
                :key="index"
                scope="col"
                class="py-3.5 text-left text-sm font-semibold text-gray-900"
                :class="[index === 0 ? 'pl-4 sm:pl-0 pr-3' : 'px-3']"
            >
                <Link
                    v-if="column.sortable"
                    :href="currentUrl"
                    :data="sortData(column)"
                    class="flex items-end gap-2 group focus:outline-none"
                >
                    <span class="inline-flex" v-text="$t(column.label)" />

                    <SortAscendingIcon
                        v-if="sort.column !== column.field || sort.direction === 'asc'"
                        :class="sortIconClass(column)"
                    />
                    <SortDescendingIcon
                        v-else-if="sort.column === column.field && sort.direction === 'desc'"
                        :class="sortIconClass(column)"
                    />
                </Link>

                <span v-else v-text="$t(column.label)" />
            </th>

            <!-- actions -->
            <th class="w-10" />
        </tr>
    </thead>
</template>

<script setup>
    import { computed } from 'vue';
    import { usePage } from '@inertiajs/vue3';
    import route from '@/Helpers/useRoute';
    import { SortAscendingIcon, SortDescendingIcon } from '@heroicons/vue/solid';

    const props = defineProps({
        columns: {
            type: Array,
            required: true,
        },
        sort: {
            type: Object,
            default: () => ({
                column: null,
                direction: null,
            }),
        },
    });

    const currentUrl = computed(() => {
        const { sort, ...params } = route().params;

        return route(route().current(), params);
    });

    const sortIconClass = (column) => [
        'inline-flex w-4 h-4 duration-150 outline-none cursor-pointer transition-color group-focus:outline-none',
        props.sort.column !== column.field
            ? 'text-gray-400 group-focus:text-primary-600 group-hover:text-primary-500'
            : 'text-primary-500 group-focus:text-primary-600 group-hover:text-primary-500',
    ];

    const sortData = (column) => {
        const request = {
            filters: usePage().props.filters,
        };

        if (props.sort.column !== column.field) {
            request.sort = column.field;
        } else if (props.sort.direction === 'asc') {
            request.sort = `-${column.field}`;
        }

        return request;
    };
</script>
