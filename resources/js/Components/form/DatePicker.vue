<template>
    <div class="relative">
        <label for="" class="block text-sm font-medium leading-6" :class="[error ? 'text-red-500' : `${color}`]">
            <span v-if="label" v-text="label" />
            <span v-else><slot /></span>
        </label>

        <VueDatePicker
            v-model="value"
            v-bind="$attrs"
            format="yyyy-MM-dd"
            model-type="yyyy-MM-dd"
            :enable-time-picker="false"
            auto-apply
        />
    </div>
</template>

<script setup>
    import { computed } from 'vue';

    import VueDatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css';

    const props = defineProps({
        label: {
            type: String,
            default: null,
        },
        color: {
            type: String,
            default: null,
        },
        error: {
            type: String,
            default: null,
        },
        modelValue: {
            required: false,
        },
    });

    const emit = defineEmits(['update:modelValue']);

    const value = computed({
        get: () => props.modelValue,
        set: (value) => emit('update:modelValue', value),
    });
</script>


<style lang="postcss">
    .dp__theme_light {
        --dp-primary-color: theme('colors.primary.500');
    }
</style>
