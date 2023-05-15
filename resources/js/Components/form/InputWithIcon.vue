<template>
    <div>
        <!-- Label -->
        <label :for="id" :class="[`block text-sm font-medium leading-6 text-${color}`]">
            <span v-if="label">{{ label }}</span>
            <span v-else><slot /></span>
        </label>


        <div class="mt-2 flex rounded-md shadow-sm">
            <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 px-3 text-gray-500 sm:text-sm">{{ icon }}</span>
            <input
                class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-turqoise-600 sm:text-sm sm:leading-6"
                :value="modelValue"
                :type="type"
                :autocomplete="hasAutocomplete"
                :required="isRequired ? 'required' : ''"
                @input="$emit('update:modelValue', $event.target.value)"
                ref="input"
                :placeholder="placeholder"
            />
        </div>

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
        label: String,
        color: String,
        icon: String,
        id: String,
        type: String,
        placeholder: String,
        hasAutocomplete: String,
        isRequired: Boolean,
        error: String,
    });

    /** Component emits. */
    defineEmits(['update:modelValue']);
</script>
