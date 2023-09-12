<template>
    <button
        :type="type"
        class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
    >
        <slot />
    </button>
</template>

<script setup>
    defineProps({
        type: {
            type: String,
            default: 'button',
        },
    });
</script>
