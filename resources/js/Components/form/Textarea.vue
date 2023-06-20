<template>
    <div>
        <!-- Label -->
        <label :for="id" :class="[`block text-sm font-medium leading-6 text-${color}`]">
            <span v-if="label">{{ label }}</span>
            <span v-else><slot /></span>
        </label>

        <div>
            <textarea
                rows="4"
                name="comment"
                id="comment"
                :value="modelValue"
                :required="isRequired ? 'required' : ''"
                @input="$emit('update:modelValue', $event.target.value)"
                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-turqoise-500 sm:text-sm sm:leading-6"
            ></textarea>
        </div>

        <slot />

        <!-- Error -->
        <p v-show="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
    </div>
</template>

<script setup>
    /** Component props. */
    const props = defineProps({
        modelValue: {
            type: String,
            required: true,
        },
        id: String,
        label: String,
        color: String,
        isRequired: Boolean,
        error: String
    });

    /** Component emits. */
    defineEmits(['update:modelValue']);
</script>
