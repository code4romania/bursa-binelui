<template>
    <Menu as="div" class="relative inline-block text-left">
        <div>
            <MenuButton class="inline-flex items-center w-full justify-center gap-x-4 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                <SvgLoader name="sort" />
                {{ $t('sort') }}
            </MenuButton>
        </div>

      <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
        <MenuItems class="absolute right-0 z-10 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">

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
