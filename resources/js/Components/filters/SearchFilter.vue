<template>
    <label class="relative flex rounded-md shadow-sm">
        <div class="sr-only" v-text="placeholder" />
        <div class="relative flex items-stretch flex-grow focus-within:z-10">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <SearchIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
            </div>
            <input
                type="search"
                class="block w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 appearance-none"
                :placeholder="placeholder"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
            />
        </div>
    </label>
</template>

<script setup>
    import { SearchIcon } from '@heroicons/vue/solid';

    defineProps({
        modelValue: {
            type: String,
            default: null,
        },
        label: String,
        placeholder: String,
        color: String,
        id: String,
    });

    defineEmits(['update:modelValue']);
</script>

<style>
    [type='search']::-webkit-search-cancel-button,
    [type='search']::-webkit-search-decoration {
        appearance: none;
    }
</style>
