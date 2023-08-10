<template>
    <Combobox
        class="z-100"
        as="div"
        v-bind="{ disabled: isDisabled }"
        v-model="selectedOptions"
        multiple
    >
        <ComboboxLabel
            class="block text-sm font-medium leading-6 text-gray-900"
            >{{ label }}</ComboboxLabel
        >
        <div class="relative">
            <ComboboxInput
                @change="query = $event.target.value"
                class="w-full rounded-md h-9 border-0 py-1.5 px-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-500 sm:text-sm sm:leading-6"
            />

            <ComboboxButton
                class="absolute inset-y-0 right-0 flex items-center px-2 rounded-r-md focus:outline-none"
            >
                <ChevronUpDownIcon
                    class="w-5 h-5 text-gray-400"
                    aria-hidden="true"
                />
            </ComboboxButton>

            <ComboboxOptions
                class="absolute w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg z-100 max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
            >
                <ComboboxOption
                    v-for="(option, index) in options"
                    :key="index"
                    :value="option"
                    as="template"
                    v-slot="{ selected, active }"
                >
                    <li
                        class="relative py-2 pl-3 cursor-default select-none pr-9"
                        :class="{
                            'bg-primary-500 text-white': active,
                            'text-gray-900': !active,
                            hidden: selected,
                        }"
                    >
                        <span
                            class="block truncate"
                            :class="{
                                'font-medium': selected,
                                'font-normal': !selected,
                            }"
                        >
                            {{ option.name ? option.name : option }}
                        </span>
                    </li>
                </ComboboxOption>
            </ComboboxOptions>
        </div>

        <div class="flex flex-wrap gap-2 mt-2">
            <button
                class="inline-flex items-center px-2 py-1 text-xs font-semibold text-white rounded-full gap-x-1 bg-primary-500"
                type="button"
                @click="remove(option)"
                v-for="(option, index) in selectedOptions"
                :key="index"
            >
                {{ option.name ? option.name : option }}

                <XCircleIcon
                    class="w-4 h-4 -mr-1 fill-white"
                    aria-hidden="true"
                />
            </button>
        </div>

        <!-- Error -->
        <p v-show="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
    </Combobox>
</template>

<script setup>
    /** Import form vue. */
    import { computed, ref, watch } from "vue";

    /** Import plugins. */
    import { ChevronUpDownIcon, XCircleIcon } from "@heroicons/vue/20/solid";
    import {
        Combobox,
        ComboboxButton,
        ComboboxInput,
        ComboboxLabel,
        ComboboxOption,
        ComboboxOptions,
    } from "@headlessui/vue";

    /** Component props. */
    const props = defineProps({
        modelValue: [String, Object, Array],
        label: String,
        options: [String, Object, Array],
        error: String,
        isDisabled: {
            type: Boolean,
            disabled: false,
        },
        type: {
            type: String,
            default: "object",
        },
    });

    /** Query input. */
    const query = ref("");

    /** Selected options. */
    let selectedOptions = ref(props.modelValue);

    /** Initialize emits. */
    const emit = defineEmits(["update:modelValue", "callback", "selected"]);

    function remove(opt) {
        if ("singleValue" === props.type) {
            selectedOptions.value = selectedOptions.value.filter(
                (option) => option != opt
            );
        } else if (props.type === "object") {
            selectedOptions.value = selectedOptions.value.filter(
                (option) => option.id !== opt.id
            );
        }

        emit("update:modelValue", selectedOptions.value);
        emit("callback");
    }

    /** Option list. */
    const options = computed(() => {
        if ("singleValue" === props.type) {
            return query.value === ""
                ? props.options
                : props.options.filter((option) => {
                      return option
                          .toLowerCase()
                          .includes(query.value.toLowerCase());
                  });
        } else if ("object" === props.type) {
            return query.value === ""
                ? props.options
                : props.options.filter((option) => {
                      return option.name
                          .toLowerCase()
                          .includes(query.value.toLowerCase());
                  });
        }
    });

    watch(
        selectedOptions,
        (values) => {
            emit("update:modelValue", values);
            emit("callback");
        },
        {
            deep: true,
        }
    );
</script>
