<template>
    <Listbox as="div" v-model="selected">
        <div class="relative text-gray-500 text-base font-medium leading-5">
            <ListboxButton class="flex items-center px-3">
                <span>{{ selected.name }}</span>
                <ChevronUpDownIcon class="h-5 w-5" aria-hidden="true" />
            </ListboxButton>

            <transition
                leave-active-class="transition ease-in duration-100"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <ListboxOptions class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                    <ListboxOption
                        as="template"
                        v-for="option in options"
                        :key="option.id"
                        :value="option"
                        v-slot="{ active, selected }"
                    >
                        <li :class="[active ? 'bg-primary-500 text-white' : '', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                            <div class="flex items-center">
                                <span :class="[selected ? 'text-primary-500 hover:text-white' : '', 'ml-3 block']">
                                    {{ option.name }}
                                </span>
                            </div>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>

<script setup>
    /** Import form vue. */
    import { ref } from 'vue';

    /** Import plugins. */
    import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue';
    import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid';

    /** Component porps. */
    const props = defineProps({
        options: { type: Array }
    });

    /** Default option. */
    const selected = ref(props.options[0]);
</script>
