<template>
    <div class="p-4 my-4 rounded-md bg-green-50" :class="color">
        <div class="flex gap-3">
            <Component :is="icon" class="w-5 h-5 shrink-0" :class="iconColor" aria-hidden="true" />

            <p class="text-sm font-medium" v-text="message" />
        </div>
    </div>
</template>

<script setup>
    import { computed } from 'vue';

    /** Import plugins. */
    import { CheckCircleIcon, ExclamationIcon, ExclamationCircleIcon } from '@heroicons/vue/solid';

    /** Component props. */
    const props = defineProps({
        type: {
            type: String,
            required: true,
            validator: (type) => ['success', 'error', 'warning'].includes(type),
        },
        message: {
            type: String,
            required: true,
        },
    });

    const icon = computed(() => {
        if (props.type === 'warning') {
            return ExclamationIcon;
        }
        if (props.type === 'error') {
            return ExclamationCircleIcon;
        }

        return CheckCircleIcon;
    });

    const iconColor = computed(() => {
        if (props.type === 'warning') {
            return 'text-yellow-500';
        }
        if (props.type === 'error') {
            return 'text-red-500';
        }

        return 'text-green-500';
    });

    const color = computed(() => {
        if (props.type === 'warning') {
            return 'bg-yellow-50 text-yellow-800';
        }
        if (props.type === 'error') {
            return 'bg-red-50 text-red-800';
        }

        return 'bg-green-50 text-green-800';
    });
</script>
