<template>
    <button
        :type="type"
        class="rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:opacity-50 disabled:cursor-default text-gray-900 bg-white ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
    >
        <slot>{{ label }}</slot>
    </button>
</template>

<script setup>
    defineProps({
        type: {
            type: String,
            default: 'button',
        },
        label: {
            type: String,
            default: null,
        },
    });
</script>
