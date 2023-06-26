<template>
    <div>
        <label class="text-sm font-semibold text-gray-700">{{ label }}</label>
        <fieldset class="mt-4">
            <div class="space-y-4">
                <div
                    v-for="option in options"
                    :key="option.value"
                    class="flex items-center"
                >
                    <input
                        :id="option.value"
                        name="test"
                        type="radio"
                        :value="option.value"
                        class="w-4 h-4 border-gray-300 text-primary-500 focus:ring-primary-500"
                    />
                    <label :for="option.value" class="block ml-3 text-sm font-medium leading-6 text-gray-900">{{ option.label }}</label>
                </div>

                <!-- Error -->
                <p v-show="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
            </div>
        </fieldset>
    </div>
</template>

<script setup>
    const props = defineProps({
        options: Array,
        error: String
    });
</script>
