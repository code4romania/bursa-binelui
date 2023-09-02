<template>
    <span
        class="inline-flex items-center px-3 py-1 text-sm text-white rounded-full drop-shadow-md gap-x-1"
        :class="[accent ? 'bg-red-500' : 'bg-primary-500']"
    >
        <Icon v-if="icon" :name="icon" class="w-4 h-4 -ml-1 shrink-0" />

        <slot>
            <span class="font-extrabold" v-text="label" />
        </slot>
    </span>
</template>

<script setup>
    import Icon from '@/Components/Icon.vue';

    const props = defineProps({
        icon: {
            type: String,
            default: null,
        },
        label: {
            type: [String, Number],
            required: true,
        },
        accent: {
            type: Boolean,
            default: false,
        },
    });
</script>
