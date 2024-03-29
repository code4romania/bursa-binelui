<template>
    <Combobox class="z-50" as="div" v-model="selectedOptions" multiple>
        <ComboboxLabel class="block text-sm font-medium leading-6 text-gray-900">{{ label }}</ComboboxLabel>
        <div class="relative">
            <div
                class="w-full flex rounded-md h-9 border-0 bg-white py-1.5 px-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-500 sm:text-sm sm:leading-6"
            >
                <p v-if="selectedOptions.length > 0">({{ selectedOptions.length }})</p>
                <ul class="flex gap-x-1" v-if="selectedOptions.length > 0">
                    <li v-for="(option, index) in selectedOptions" :key="index">
                        {{ option }}
                    </li>
                </ul>
            </div>

            <ComboboxButton class="absolute inset-y-0 right-0 flex items-center px-2 rounded-r-md focus:outline-none">
                <SelectorIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
            </ComboboxButton>

            <ComboboxOptions
                class="absolute w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg z-103 max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
            >
                <div class="z-100 my-1.5 sticky top-1.5 px-2 bg-white">
                    <input
                        v-model="query"
                        class="w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-1 outline-none focus:ring-inset focus:ring-primary-500 sm:text-sm sm:leading-6"
                    />
                </div>
                <!-- <div class="z-101 bg-white my-1.5 sticky top-1.5 px-2">
                    <ComboboxInput
                        class="w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-500 sm:text-sm sm:leading-6"
                        @input="query = $event.target.value"
                    />
                </div> -->

                <ComboboxOption
                    v-for="(option, index) in selectOptions"
                    :key="index"
                    :value="option"
                    as="template"
                    v-slot="{ active, selected }"
                >
                    <li
                        :class="[
                            'relative cursor-default select-none py-2 pl-3 pr-9',
                            active ? 'bg-primary-500 text-white' : 'text-gray-900',
                        ]"
                    >
                        <span :class="['block truncate', selected && 'font-semibold']">
                            {{ option }}
                        </span>

                        <span
                            v-if="selected"
                            :class="[
                                'absolute inset-y-0 right-0 flex items-center pr-4',
                                active ? 'text-white' : 'text-primary-500',
                            ]"
                        >
                            <CheckIcon class="w-5 h-5" aria-hidden="true" />
                        </span>
                    </li>
                </ComboboxOption>
            </ComboboxOptions>
        </div>
    </Combobox>
</template>

<script setup>
    import { computed, ref, watch } from 'vue';
    import { CheckIcon, SelectorIcon } from '@heroicons/vue/solid';
    import {
        Combobox,
        ComboboxButton,
        ComboboxInput,
        ComboboxLabel,
        ComboboxOption,
        ComboboxOptions,
    } from '@headlessui/vue';

    /** Component props. */
    const props = defineProps({
        modelValue: [String, Object, Array],
        label: String,
        options: [String, Object, Array],
    });

    /** Query input. */
    const query = ref('');

    const emit = defineEmits(['update:modelValue']);

    /** Option list. */
    const selectOptions = computed(() =>
        query.value === ''
            ? props.options
            : props.options.filter((option) => {
                  return option.toLowerCase().includes(query.value.toLowerCase());
              })
    );

    /** Update option list based on input query. */
    const selectedOptions = computed({
        get() {
            return props.modelValue || [];
        },
        set(value) {
            emit('update:modelValue', value);
            emit('callback', value);
        },
    });
</script>

<style scoped>
    ul {
        flex-wrap: nowrap;
        overflow-x: auto;
        white-space: nowrap;
    }
    ul::-webkit-scrollbar {
        display: none;
    }
</style>
