<template>
    <Menu as="div" class="relative inline-block text-left z-101">
        <div>
            <MenuButton class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm gap-x-4 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                <SvgLoader name="sort" />
                {{ $t('sort') }}
            </MenuButton>
        </div>

      <transition enter-active-class="transition duration-100 ease-out" enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
        <MenuItems class="absolute right-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg z-101 ring-1 ring-black ring-opacity-5 focus:outline-none">

            <div class="py-1">
                <MenuItem v-slot="{ active }">
                    <p
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm cursor-pointer']"
                    >
                        {{ $t('publish_date') }}
                    </p>
                </MenuItem>
            </div>

            <div class="py-1">
                <MenuItem v-slot="{ active }">
                    <p
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm cursor-pointer']"
                    >
                        {{ $t('end_project_date') }}
                    </p>
                </MenuItem>
            </div>

            <div class="py-1">
                <MenuItem v-slot="{ active }">
                    <p
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm cursor-pointer']"
                    >
                        {{ $t('target') }}
                    </p>
                </MenuItem>
            </div>

            <div class="py-1">
                <MenuItem v-slot="{ active }">
                    <p
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm cursor-pointer']"
                    >
                        {{ $t('donated_amount') }}
                    </p>
                </MenuItem>
            </div>

            <div class="py-1">
                <MenuItem v-slot="{ active }">
                    <p
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm cursor-pointer']"
                    >
                        {{ $t('donation_number') }}
                    </p>
                </MenuItem>
            </div>

        </MenuItems>
      </transition>
    </Menu>
  </template>

<script setup>
    /** Import plugins. */
    import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';

    /** Import components. */
    import SvgLoader from '@/Components/SvgLoader.vue';


</script>
