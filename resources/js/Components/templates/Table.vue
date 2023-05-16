<template>
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th v-for="(column, index) in columns" :key="index" scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ column }}</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <slot />
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <Pagination
                    class="mt-6"
                    v-if="links"
                    :currentPage="currentPage"
                    :prev="prev"
                    :next="next"
                    :links="links"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
    /** Import components */
    import Pagination from '@/Components/pagination/Pagination.vue';

    /** Component props. */
    const props = defineProps({
        columns:  Array,
        currentPage: Number,
        prev: String,
        next: String,
        links: Array
    });
</script>
