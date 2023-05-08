<template>
    <div>
        <!-- Label -->
        <label :for="id" :class="[`block text-sm font-medium leading-6 text-${white}`]">
            <span v-if="label">{{ label }}</span>
            <span v-else><slot /></span>
        </label>

        <!-- Input -->
        <input
            class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-cyan-500 sm:text-sm sm:leading-6"
            :value="modelValue"
            :type="type"
            :autocomplete="hasAutocomplete"
            :required="isRequired ? 'required' : ''"
            @input="$emit('update:modelValue', $event.target.value)"
            ref="input"
            :placeholder="placeholder"
        />

        <!-- Error -->
        <p v-show="error" class="mt-2 text-sm text-red-600">{{ error }}</p>

        <!-- Extra -->
        <slot />
    </div>
</template>

<script setup>
    /** Import from vue. */
    import { onMounted, ref } from 'vue';

    /** Component props. */
    const props = defineProps({
        modelValue: {
            type: String,
            required: true,
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
            type: String
        },
        labelColor:{
            type: String
        }
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
