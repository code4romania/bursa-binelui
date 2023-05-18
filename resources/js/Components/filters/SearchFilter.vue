<template>
    <div>
         <!-- Label -->
         <label :for="id" :class="[`block text-sm font-medium leading-6 text-${color}`]">
            <span v-if="label">{{ label }}</span>
            <span v-else><slot /></span>
        </label>
        <!-- Input -->
        <input
            class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-turqoise-500 sm:text-sm sm:leading-6"
            :value="modelValue"
            type="search"
            @input="$emit('update:modelValue', $event.target.value)"
            :placeholder="placeholder"
        />
    </div>
</template>

<script setup>
    /** Component props. */
    const props = defineProps({
        modelValue: {
            type: String,
            required: true,
        },
        label: String,
        placeholder: String,
        color: String,
        id: String
    });

    /** Component emits. */
    defineEmits(['update:modelValue']);
</script>
