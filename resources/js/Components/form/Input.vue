<template>
    <div>
        <!-- Label -->
        <label :for="id" :class="[`block text-sm font-medium leading-7 text-${color}`]">
            <span v-if="label">{{ label }}</span>
            <span v-else><slot /></span>
        </label>

        <!-- Input -->
        <input
            class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 sm:text-sm sm:leading-7"
            :value="modelValue"
            :type="type"
            :autocomplete="hasAutocomplete"
            v-bind="{ required: isRequired }"
            @input="$emit('update:modelValue', $event.target.value)"
            ref="input"
            :placeholder="placeholder"
            :pattern="pattern"
            :min="min"
            :max="max"
            :disabled="disabled"
            :maxlength="maxlength"
        />

        <!-- Extra -->
        <slot />

        <!-- Error -->
        <p v-show="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
    </div>
</template>

<script setup>
    /** Import from vue. */
    import { onMounted, ref } from 'vue';

    /** Component props. */
    const props = defineProps({
        modelValue: {
            type: String,
        },
        error: {
            type: String,
        },
        label: {
            type: String,
        },
        id: {
            type: String,
        },
        type: {
            type: String,
        },
        hasAutocomplete: {
            type: String,
        },
        isRequired: {
            type: Boolean,
        },
        placeholder: {
            type: String,
        },
        color: {
            type: String,
        },
        pattern: {
            type: String,
            default: null,
        },
        min: {
            type: Number,
            default: null,
        },
        max: {
            type: Number,
            default: null,
        },
        maxlength: {
            type: Number,
            default: null,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
    });

    /** Component emits. */
    defineEmits(['update:modelValue']);

    /** Component ref identificator. */
    const input = ref(null);

    /** On Mounted. */
    onMounted(() => {
        if (input.value.hasAttribute('autofocus')) {
            input.value.focus();
        }
    });

    /** Expose. */
    defineExpose({ focus: () => input.value.focus() });
</script>

<style scoped>
    input::-webkit-inner-spin-button,
    input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
