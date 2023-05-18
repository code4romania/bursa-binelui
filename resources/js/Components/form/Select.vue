<template>

    <Combobox as="div" v-model="selectedOption">
        <ComboboxLabel class="block text-sm font-medium leading-6 text-gray-900">{{ label }}</ComboboxLabel>
        <div class="relative">
            <ComboboxButton class="w-full rounded-md h-9 border-0 bg-white py-1.5 px-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-turqoise-500 sm:text-sm sm:leading-6">
                <ul
                    class="flex gap-x-1"
                >
                    <li v-if="selectedOption">
                        {{ selectedOption.name ? selectedOption.name : selectedOption }}
                    </li>
                </ul>
            </ComboboxButton>

            <ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
            </ComboboxButton>

            <ComboboxOptions
                class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
            >
                <div class="z-20 my-1.5 sticky top-1.5 px-2">
                    <ComboboxInput
                        class="w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-turqoise-500 sm:text-sm sm:leading-6"
                        @input="query = $event.target.value"
                    />
                </div>

                <ComboboxOption
                    v-for="option in selectOptions" :key="option.id"
                    :value="option"
                    as="template"
                    v-slot="{ active, selected }"
                >
                    <li :class="['relative cursor-default select-none py-2 pl-3 pr-9', active ? 'bg-turqoise-500 text-white' : 'text-gray-900']">
                        <span :class="['block truncate', selected && 'font-semibold']">
                            {{ option.name ? option.name : option }}
                        </span>

                        <span v-if="selected" :class="['absolute inset-y-0 right-0 flex items-center pr-4', active ? 'text-white' : 'text-turqoise-500']">
                            <CheckIcon class="h-5 w-5" aria-hidden="true" />
                        </span>
                    </li>
                </ComboboxOption>
            </ComboboxOptions>
        </div>

        <!-- Error -->
        <p v-show="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
    </Combobox>
</template>

<script setup>
    /** Import form vue. */
    import { computed, ref, watch } from 'vue';

    /** Import plugins. */
    import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid';
    import { Combobox, ComboboxButton, ComboboxInput, ComboboxLabel, ComboboxOption, ComboboxOptions } from '@headlessui/vue';

    /** Component props. */
    const props = defineProps({
        modelValue: [String, Object, Array],
        label: String,
        options: [String, Object, Array],
        error: String
    });

    /** Query input. */
    const query = ref('');

    /** Selected options. */
    const selectedOption = ref(props.modelValue);

    /** Initialize emits. */
    const emit = defineEmits(['update:modelValue', 'selected']);

    /** Option list. */
    const selectOptions = computed(() =>
        query.value === '' ? props.options : props.options.filter((option) => {
            return option.name.toLowerCase().includes(query.value.toLowerCase())
        })
    );

    /** Watch changes in selected options. */
    watch(selectedOption, (newVal, oldVal) => {
        if (newVal != oldVal) {
            emit('update:modelValue', selectedOption.value);
            emit('selected', selectedOption.value)
        }
    })
</script>

<style scoped>
    ul {
        flex-wrap: nowrap;
        overflow-x: auto;
        white-space: nowrap;
    }
</style>
