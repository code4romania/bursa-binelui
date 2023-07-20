<template>
    <Combobox class="z-100" as="div" v-model="selectedOption" v-bind="{ disabled: isDisabled }">
        <ComboboxLabel class="block text-sm font-medium leading-6 text-gray-900">{{ label }}</ComboboxLabel>
        <div class="relative">
            <ComboboxButton
                :class="[ isDisabled ? 'bg-gray-200' : 'bg-white', 'w-full rounded-md h-9 border-0  py-1.5 px-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-500 sm:text-sm sm:leading-6']">
            </ComboboxButton>

            <ComboboxButton class="absolute inset-y-0 right-0 flex items-center px-2 rounded-r-md focus:outline-none">
                <ChevronUpDownIcon class="w-5 h-5 text-gray-400" aria-hidden="true"/>
            </ComboboxButton>

            <ComboboxOptions
                class="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
            >
                <div class="z-100 my-1.5 sticky top-1.5 px-2 bg-white">
                    <input
                        v-model="query"
                        class="w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-1 outline-none focus:ring-inset focus:ring-primary-500 sm:text-sm sm:leading-6"
                    />
                </div>

                <ComboboxOption
                    v-for="(option ,index) in selectOptions" :key="index"
                    :value="option"
                    as="template"
                >
                    <li
                        @click="toggleOptions(option)"
                        :class="['relative cursor-default select-none py-2 pl-3 pr-9',('singleValue' === type && tmpSelectedOptions.includes(option)) || ('object' === type && tmpSelectedOptions.includes(option)) ? 'bg-primary-500 text-white' : 'text-gray-900']"
                    >
                        <span :class="['block truncate', ('singleValue' === type && tmpSelectedOptions.includes(option)) || ('object' === type && tmpSelectedOptions.includes(option)) && 'font-semibold']">
                            {{ option.name ? option.name : option }}
                        </span>

                        <span v-if="('singleValue' === type && tmpSelectedOptions.includes(option)) || ('object' === type && tmpSelectedOptions.includes(option))"
                              :class="['absolute inset-y-0 right-0 flex items-center pr-4', ('singleValue' === type && tmpSelectedOptions.includes(option)) || ('object' === type && tmpSelectedOptions.includes(option)) ? 'text-white' : 'text-primary-500']">
                            <CheckIcon class="w-5 h-5" aria-hidden="true"/>
                        </span>
                    </li>
                </ComboboxOption>
            </ComboboxOptions>
        </div>
        <div
            @click="removeElement(option)"
            class="inline-flex items-center px-3 py-1 mt-2 mr-2 text-xs font-bold text-white uppercase rounded-full cursor-pointer group bg-primary-500 leading-sm bg-primary text-primary"
            v-for="option in tmpSelectedOptions"
        >
            {{ option.name ? option.name : option }}
            <XCircleIcon class="w-4 h-4 ml-2 text-white" aria-hidden="true"/>
        </div>

        <!-- Error -->
        <p v-show="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
    </Combobox>
</template>

<script setup>
/** Import form vue. */
import {computed, ref, watch} from 'vue';

/** Import plugins. */
import {CheckIcon, ChevronUpDownIcon, XCircleIcon} from '@heroicons/vue/20/solid';
import {Combobox, ComboboxButton, ComboboxInput, ComboboxLabel, ComboboxOption, ComboboxOptions} from '@headlessui/vue';

/** Component props. */
const props = defineProps({
    modelValue: [String, Object, Array],
    label: String,
    options: [String, Object, Array],
    error: String,
    isDisabled: {
        type: Boolean,
        disabled: false
    },
    type: {
        type: String,
        default: 'object'
    }
});

/** Query input. */
const query = ref('');

/** Selected options. */
let tmpSelectedOptions = ref(props.modelValue);

let selectedOption = ref(props.modelValue);

/** Initialize emits. */
const emit = defineEmits(['update:modelValue', 'selected']);

function removeElement(opt) {
    if ('singleValue' === props.type) {
        tmpSelectedOptions.value = tmpSelectedOptions.value.filter((option) => option != opt);
    } else if (props.type === 'object') {
        tmpSelectedOptions.value = tmpSelectedOptions.value.filter((option) => option.id !== opt.id);
    }

    emit('update:modelValue', tmpSelectedOptions.value)
}

/** Option list. */
const selectOptions = computed(() => {
    if('singleValue' === props.type) {
        return query.value === '' ? props.options : props.options.filter((option) => {
            return option.toLowerCase().includes(query.value.toLowerCase())
        })
    }else if ('object' === props.type) {
        return query.value === '' ? props.options : props.options.filter((option) => {
            return option.name.toLowerCase().includes(query.value.toLowerCase())
        })
    }
});

const toggleOptions = (newVal) => {
    if ('singleValue' === props.type) {
        if(!tmpSelectedOptions.value.includes(newVal)) {
            tmpSelectedOptions.value.push(newVal);
        } else {
            tmpSelectedOptions.value = tmpSelectedOptions.value.filter((option) => `${option}` != `${newVal}`)
        }

    } else if ('object' === props.type) {
        if(!tmpSelectedOptions.value.includes(newVal)) {
            tmpSelectedOptions.value.push(newVal);
        } else {
            tmpSelectedOptions.value = tmpSelectedOptions.value.filter((option) => option.id != newVal.id)
        }
    }
    emit('update:modelValue', tmpSelectedOptions.value);
}
</script>
