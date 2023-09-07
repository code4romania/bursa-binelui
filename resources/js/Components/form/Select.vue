<template>
    <div>
        <label class="block text-sm font-medium leading-6 text-gray-700" v-text="label" />
        <Multiselect
            v-model="value"
            :options="options"
            :mode="multiple ? 'multiple' : 'single'"
            searchable
            :strict="false"
            :hideSelected="false"
            :classes="{
                container: `relative flex items-stretch justify-end w-full mx-auto text-base leading-snug bg-white ring-1 ring-inset ring-gray-300 shadow-sm rounded outline-none cursor-pointer`,
                containerDisabled: `cursor-default bg-gray-100`,
                containerActive: `outline-none ring-2 ring-primary-600`,
                wrapper: `relative flex items-center justify-end w-full mx-auto outline-none cursor-pointer gap-2 pl-3.5 pr-2`,
                singleLabel: `flex items-center h-full max-w-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pr-16`,
                singleLabelText: `overflow-ellipsis overflow-hidden block whitespace-nowrap max-w-full`,
                search: `absolute inset-[2px] outline-none focus:ring-0 appearance-none border-0 text-base font-sans bg-white rounded sm:text-sm`,
                tags: `flex-grow flex-shrink flex flex-wrap items-center mt-1 pl-2`,
                tag: `bg-primary-500 text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap`,
                tagDisabled: `pr-2 opacity-50`,
                tagRemove: `flex items-center justify-center p-1 mx-0.5 rounded-sm hover:bg-black hover:bg-opacity-10 group`,
                tagRemoveIcon: `bg-multiselect-remove bg-center bg-no-repeat opacity-30 inline-block w-3 h-3 group-hover:opacity-60`,
                tagsSearchWrapper: `inline-block relative mx-1 mb-1 flex-grow flex-shrink h-full`,
                tagsSearch: `absolute inset-[2px] border-0 outline-none focus:ring-0 appearance-none p-0 text-base font-sans`,
                tagsSearchCopy: `invisible whitespace-pre-wrap inline-block h-px`,
                placeholder: `flex items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug text-gray-400`,
                clear: `pr-3.5 relative z-10 opacity-40 transition duration-300 flex-shrink-0 flex-grow-0 flex hover:opacity-80`,
                clearIcon: `bg-multiselect-remove bg-center bg-no-repeat w-2.5 h-4 py-px inline-block`,
                spinner: `bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 mr-3.5 animate-spin flex-shrink-0 flex-grow-0`,
                inifite: `flex items-center justify-center w-full`,
                inifiteSpinner: `bg-multiselect-spinner bg-center bg-no-repeat w-4 h-4 z-10 animate-spin flex-shrink-0 flex-grow-0 m-3.5`,
                dropdown: `absolute z-10 mt-2 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm top-full -left-px -right-px `,
                dropdownHidden: `hidden`,
                options: `flex flex-col p-0 m-0 list-none`,
                optionsTop: ``,
                group: `p-0 m-0`,
                groupLabel: `flex text-sm items-center justify-start text-left py-1 px-3 font-semibold bg-gray-200 cursor-default leading-normal`,
                groupLabelPointable: `cursor-pointer`,
                groupLabelPointed: `bg-gray-300 text-gray-700`,
                groupLabelSelected: `bg-primary-600 text-white`,
                groupLabelDisabled: `bg-gray-100 text-gray-300 cursor-not-allowed`,
                groupLabelSelectedPointed: `bg-primary-600 text-white opacity-90`,
                groupLabelSelectedDisabled: `text-primary-100 bg-primary-600 bg-opacity-50 cursor-not-allowed`,
                groupOptions: `p-0 m-0`,
                option: `flex items-center justify-start text-left cursor-pointer text-base leading-snug py-2 px-3 sm:text-sm`,
                optionPointed: `text-white bg-primary-600`,
                optionSelected: `font-semibold`,
                optionDisabled: `text-gray-300 cursor-not-allowed`,
                optionSelectedPointed: `text-white bg-primary-600`,
                optionSelectedDisabled: `text-primary-100 bg-primary-600 bg-opacity-50 cursor-not-allowed`,
                noOptions: `py-2 px-3 text-gray-600 bg-white text-left`,
                noResults: `py-2 px-3 text-gray-600 bg-white text-left`,
                fakeInput: `bg-transparent absolute left-0 right-0 -bottom-px w-full h-px border-0 p-0 appearance-none outline-none text-transparent`,
                assist: 'sr-only',
                spacer: `h-9 py-px`,
            }"
        >
            <template #option="{ option, isSelected, isPointed }">
                <div class="flex justify-between w-full gap-4">
                    <span
                        class="block truncate"
                        :class="{ 'font-semibold': isSelected(option) }"
                        v-text="option.label"
                    />

                    <CheckIcon
                        v-if="isSelected(option)"
                        class="w-5 h-5 shrink-0"
                        aria-hidden="true"
                        :class="[isPointed(option) ? 'text-white' : 'text-primary-600']"
                    />
                </div>
            </template>

            <template #multiplelabel="{ values }">
                <div class="relative flex items-center flex-1 h-full py-px overflow-hidden">
                    <span class="text-base truncate sm:text-sm">
                        <span v-if="values.length > 1">({{ values.length }})</span>
                        {{ values.map((item) => item.label).join(', ') }}
                    </span>
                </div>
            </template>

            <template #caret>
                <span class="relative z-10 flex items-center justify-center h-full py-px cursor-pointer shrink-0">
                    <SelectorIcon class="relative z-10 w-5 h-5 text-gray-400" aria-hidden="true" />
                </span>
            </template>

            <template #clear="{ clear }">
                <button
                    tabindex="0"
                    data-clear
                    aria-roledescription="❎"
                    class="relative z-10 flex items-center justify-center h-full py-px cursor-pointer shrink-0"
                    @click="clear"
                    @keyup.enter="clear"
                >
                    <XIcon class="relative z-10 w-4 h-full text-gray-400" aria-hidden="true" />
                </button>
            </template>
        </Multiselect>
    </div>
</template>

<script setup>
    import { ref, computed } from 'vue';
    import Multiselect from '@vueform/multiselect';
    import { SelectorIcon, XIcon, CheckIcon } from '@heroicons/vue/outline';

    const props = defineProps({
        label: {
            type: String,
        },
        options: {
            type: [Array, Object],
            required: true,
        },
        multiple: {
            type: Boolean,
            default: false,
        },
        modelValue: {
            required: false,
        },
    });

    const emit = defineEmits(['update:modelValue']);

    const value = computed({
        get: () => props.modelValue,
        set: (value) => emit('update:modelValue', value),
    });
</script>
