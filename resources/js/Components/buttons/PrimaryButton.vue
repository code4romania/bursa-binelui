<template>
    <button
        :class="[
            `bg-${background}
            hover:bg-${hover}
            text-${color}
            focus-visible:outline-${background}
            rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2`
        ]"
    >
        <slot />
    </button>
</template>

<script setup>
    /** Component props. */
    defineProps({
        background: { type: String },
        hover: { type: String },
        color: {type: String }
    });
</script>
