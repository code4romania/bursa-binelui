<template>
    <Popover class="relative">
        <PopoverButton
            class="flex items-center justify-between w-full p-3 text-base font-medium leading-5 lg:w-auto lg:p-0 lg:inline-flex focus:outline-none gap-x-1"
            :class="{
                'bg-primary-50 lg:bg-transparent text-primary-500 lg:hover:text-primary-400': isActive,
                'text-gray-500 lg:hover:text-primary-500': !isActive,
            }"
        >
            <span v-text="name" />
            <ChevronDownIcon class="w-5 h-5" aria-hidden="true" />
        </PopoverButton>

        <TransitionRoot
            enter="transition duration-200 ease-out"
            enter-from="translate-y-1 opacity-0"
            enter-to="translate-y-0 opacity-100"
            leave="transition duration-150 ease-in"
            leave-from="translate-y-0 opacity-100"
            leave-to="translate-y-1 opacity-0"
        >
            <PopoverPanel class="absolute z-50 flex px-4 -translate-x-1/2 left-1/2 lg:mt-5">
                <div
                    class="grid flex-auto w-screen max-w-sm p-4 text-sm leading-6 bg-white rounded-lg drop-shadow ring-1 ring-gray-200"
                >
                    <NavLink
                        v-for="(link, index) in links"
                        :key="index"
                        :href="link.href"
                        class="flex-col items-start justify-start block w-full gap-1 p-4 rounded-lg hover:bg-gray-50"
                    >
                        <p class="font-semibold text-gray-900" v-text="link.name" />
                        <p v-if="link.description" class="text-sm text-gray-600" v-text="link.description" />
                    </NavLink>
                </div>
            </PopoverPanel>
        </TransitionRoot>
    </Popover>
</template>

<script setup>
    import { computed } from 'vue';
    import { Popover, PopoverButton, PopoverPanel, TransitionRoot } from '@headlessui/vue';
    import { ChevronDownIcon } from '@heroicons/vue/solid';
    import route from '@/Helpers/useRoute';

    /** Import components. */
    import NavLink from '@/Components/links/NavLink.vue';

    /** Component props. */
    const props = defineProps({
        name: String,
        links: Array,
    });

    const isActive = computed(() => props.links.some((link) => route().current(link.href)));
</script>
