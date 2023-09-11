<template>
    <div class="flow-root mt-8">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-300">
                    <TableHeader :columns="collection.columns" :sort="collection.sort" />

                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="(row, rowIndex) in collection.data" :key="rowIndex">
                            <td
                                v-for="(column, columnIndex) in collection.columns"
                                :key="`${rowIndex}-${columnIndex}`"
                                class="py-4 text-sm whitespace-nowrap"
                                :class="[
                                    columnIndex === 0
                                        ? 'pl-4 pr-3 font-medium text-gray-900 sm:pl-0'
                                        : 'text-gray-500 px-3',
                                ]"
                            >
                                <slot :name="column.field" :[column.field]="row[column.field]" :row="row">
                                    {{ row[column.field] }}
                                </slot>
                            </td>

                            <td
                                class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0"
                            >
                                <slot name="actions" :row="row" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <Pagination v-if="shouldPaginate" :resource="collection" />

        <TableEmptyState v-if="!collection.data.length" :properties="collection.properties" />
    </div>
</template>

<script setup>
    import { computed } from 'vue';
    import TableHeader from '@/Components/tables/TableHeader.vue';
    import TableEmptyState from '@/Components/tables/TableEmptyState.vue';
    import Pagination from '@/Components/pagination/Pagination.vue';

    const props = defineProps({
        collection: {
            type: Object,
            required: true,
        },
    });

    const shouldPaginate = computed(() => {
        return props.collection.meta.last_page > 1;
    });
</script>
