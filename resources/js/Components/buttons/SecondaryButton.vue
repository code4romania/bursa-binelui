<template>
    <button
        :type="type"
        class="rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
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
