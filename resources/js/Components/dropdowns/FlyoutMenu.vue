<template>
    <Popover class="relative">
        <PopoverButton
            :class="
                [
                    'flex w-full lg:w-auto justify-between p-3 lg:p-0 lg:inline-flex items-center text-base font-medium leading-5',
                    `${setActive(route().current()) ? 'bg-turqoise-50 lg:bg-transparent text-turqoise-500 lg:hover:text-turqoise-400' : 'text-gray-500 lg:hover:text-turqoise-500'}`
                ]"
            >
            {{ name }}
            <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
        </PopoverButton>

        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
        >
            <PopoverPanel class="absolute left-1/2 z-50 lg:mt-5 flex w-screen max-w-max -translate-x-1/2 px-4">
                <div class="w-screen max-w-sm flex-auto rounded-3xl bg-white p-4 text-sm leading-6 shadow-lg ring-1 ring-gray-900/5">

                    <div v-for="link in links" :key="link.name" class="relative rounded-lg p-4 hover:bg-gray-50">
                        <NavLink :href="route(`${link.href}`)" :active="route().current(`${link.href}`)">
                            {{ link.name }}
                        </NavLink>

                        <p v-if="link.description" :class="[`mt-1 text-gray-600`]">{{ link.description }}</p>
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
