<template>
    <Popover class="relative">
        <PopoverButton
            :class="
                [
                    'flex w-full lg:w-auto justify-between p-3 lg:p-0 lg:inline-flex items-center text-base font-medium leading-5 focus:outline-none',
                    `${setActive(route().current()) ? 'bg-primary-50 lg:bg-transparent text-primary-500 lg:hover:text-primary-400' : 'text-gray-500 lg:hover:text-primary-500'}`
                ]"
            >
            {{ name }}
            <ChevronDownIcon class="w-5 h-5" aria-hidden="true" />
        </PopoverButton>

        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="translate-y-1 opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="translate-y-0 opacity-100"
            leave-to-class="translate-y-1 opacity-0"
        >
            <PopoverPanel class="absolute z-50 flex w-screen px-4 -translate-x-1/2 left-1/2 lg:mt-5 max-w-max">
                <div class="flex-auto w-screen max-w-sm p-4 text-sm leading-6 bg-white shadow-lg rounded-3xl ring-1 ring-gray-900/5">

                    <div v-for="link in links" :key="link.name" class="relative p-4 rounded-lg hover:bg-gray-50">
                        <NavLink
                            :href="route(`${link.href}`)"
                            :active="route().current(`${link.href}`)"
                            class="flex-col items-start justify-start"
                        >
                            <p class="w-full text-left">{{ link.name }}</p>
                            <p v-if="link.description" :class="[`mt-2 text-gray-500 text-sm`]">{{ link.description }}</p>
                        </NavLink>
                    </div>
                </div>
            </PopoverPanel>
        </transition>
    </Popover>
</template>

<script setup>
    /** Import plugins. */
    import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue';
    import { ChevronDownIcon } from '@heroicons/vue/20/solid';

    /** Import components. */
    import NavLink from '@/Components/links/NavLink.vue';

    /** Component props. */
    const props = defineProps({
        name: String,
        links: Array
    });

    /**
     * Determines if a navigation item should be active based on the current route.
     *
     * @param {Object} item The navigation item to check.
     *
     * @returns {Boolean} Whether or not the navigation item should be active.
     */
    const setActive = (currentRoute) => {
        return props.links.some(link => route().current(link.href));
    }
</script>
