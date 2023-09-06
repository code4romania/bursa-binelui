<template>
    <div class="p-4 my-4 rounded-md bg-green-50">
        <div class="flex gap-3">
            <CheckCircleIcon class="w-5 h-5 text-green-400 shrink-0" aria-hidden="true" />

            <p class="text-sm font-medium text-green-800" v-text="message" />
        </div>
    </div>
</template>

<script setup>
    /** Import form vue. */
    import { ref } from 'vue';

    /** Import plugins. */
    import { CheckCircleIcon } from '@heroicons/vue/solid';

    /** Component props. */
    const props = defineProps({
        message: {
            type: String,
            required: true,
        },
    });
</script>
