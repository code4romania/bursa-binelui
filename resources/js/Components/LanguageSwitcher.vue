<template>
    <Menu v-if="locales.length > 1" as="div" class="relative inline-block text-left">
        <div>
            <MenuButton
                class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 hover:text-primary-500"
            >
                {{ locales[currentLocale] }}
                <ChevronDownIcon class="w-5 h-5 -mr-1 text-gray-400" aria-hidden="true" />
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
                class="absolute right-0 z-10 w-32 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
            >
                <div class="py-1">
                    <MenuItem v-for="(name, code) in locales" :key="code" v-slot="{ active }">
                        <Link
                            href="#"
                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']"
                        >
                            {{ name }}
                        </Link>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
    import { computed } from 'vue';
    import { usePage } from '@inertiajs/vue3';
    import { trans } from 'laravel-vue-i18n';

    import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
    import { ChevronDownIcon } from '@heroicons/vue/solid';

    const currentLocale = computed(() => usePage().props.locales?.current);

    const locales = computed(() => {
        let available = usePage().props.locales?.available || [];

        return available
            .map((locale) => ({
                name: trans(`locales.${locale}`),
                code: locale,
            }))
            .reduce(
                (acc, current) => ({
                    ...acc,
                    [current.code]: current.name,
                }),
                {}
            );
    });
</script>
