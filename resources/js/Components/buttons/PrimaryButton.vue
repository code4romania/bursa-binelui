<template>
    <button
        :type="type"
        class="rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:opacity-50 disabled:cursor-default"
        :class="[color]"
    >
        <slot>{{ label }}</slot>
    </button>
</template>

<script setup>
    import { computed } from 'vue';

    const props = defineProps({
        type: {
            type: String,
            default: 'button',
        },
        label: {
            type: String,
            default: null,
        },
        color: {
            type: String,
            default: 'primary',
            validator: (color) => ['primary', 'success', 'danger', 'warning', 'gray'].includes(color),
        },
    });

    const color = computed(
        () =>
            ({
                primary: 'bg-primary-500 hover:bg-primary-400 text-white focus-visible:outline-primary-500',
                success: 'bg-success-500 hover:bg-success-400 text-white focus-visible:outline-success-500',
                danger: 'bg-danger-500 hover:bg-danger-400 text-white focus-visible:outline-danger-500',
                warning: 'bg-warning-500 hover:bg-warning-400 text-white focus-visible:outline-warning-500',
                gray: 'bg-gray-100 hover:bg-gray-200 text-gray-700 focus-visible:outline-gray-100',
            }[props.color])
    );
</script>
