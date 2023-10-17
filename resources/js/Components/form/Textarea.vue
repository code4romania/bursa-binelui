<template>
    <div>
        <!-- Label -->
        <label :for="id" :class="[`block text-sm font-medium leading-6 text-${color}`]">
            <span v-if="label">{{ label }}</span>
            <span v-else><slot /></span>
            <br/>
            <span v-show="moreInfo" class="text-sm font-normal text-gray-500" v-html="moreInfo"/>
            <slot/>
        </label>

        <div>
            <textarea
                rows="4"
                name="comment"
                id="comment"
                :value="modelValue"
                :required="isRequired ? 'required' : ''"
                @input="$emit('update:modelValue', $event.target.value)"
                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 sm:text-sm sm:leading-6"
            ></textarea>
        </div>
        <p class="text-xs font-normal " :class="{'text-red-600':(remainingNumberOfCharters===0)}">{{ remainingNumberOfCharters}}</p>

        <!-- Error -->
        <p v-show="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
    </div>
</template>

<script setup>
    import {computed} from "vue";

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
        error: String,
        moreInfo: {
            type: String,
            default: null,
        },
        numberOfCharacters: {
            type: Number,
            default: 1000,
        },
    });
    const remainingNumberOfCharters = computed(() => {
        if (props.modelValue.length > props.numberOfCharacters) {
            return 0;
        }
        return props.numberOfCharacters - props.modelValue.length;
    })


    /** Component emits. */
    defineEmits(['update:modelValue']);
</script>
