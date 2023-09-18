<template>
    <Menu as="div" class="relative inline-block text-left z-101">
        <div>
            <MenuButton
                class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm gap-x-1.5 ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
            >
                <MenuAlt1Icon class="w-5 h-5 shrink-0" />
                {{ $t('sort.trigger') }}
            </MenuButton>
        </div>

        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <MenuItems
                as="ul"
                class="absolute right-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg z-101 ring-1 ring-black ring-opacity-5 focus:outline-none"
            >
                <div class="py-1">
                    <MenuItem as="li" v-for="(column, index) in items" :key="index" v-slot="{ active }">
                        <Link
                            :href="currentUrlWithoutSort"
                            :data="sortData(column)"
                            class="flex items-center justify-between w-full gap-1 px-4 py-2 text-sm"
                            :class="[
                                active ? 'bg-gray-100' : '',
                                isSortingBy(column) ? 'text-primary-600 font-semibold' : 'text-gray-900 font-medium',
                            ]"
                        >
                            <span class="truncate" v-text="$t(`sort.${column}`)" />

                            <SortAscendingIcon v-if="isSortingBy(column, 'asc')" class="inline-flex w-5 h-5" />
                            <SortDescendingIcon v-else-if="isSortingBy(column, 'desc')" class="inline-flex w-5 h-5" />
                        </Link>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
    import { computed } from 'vue';
    import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
    import { MenuAlt1Icon, SortAscendingIcon, SortDescendingIcon } from '@heroicons/vue/solid';
    import { trans } from 'laravel-vue-i18n';
    import route from 'ziggy-js';
    import useSort from '@/Helpers/useSort.js';

    const props = defineProps({
        sort: {
            type: Object,
            default: () => ({
                column: null,
                direction: null,
            }),
        },
    });

    const { currentUrlWithoutSort, sortData, isSortingBy } = useSort(props.sort);

    const items = ['publish_date', 'end_date', 'target', 'donations_total', 'donations_count'];
</script>
