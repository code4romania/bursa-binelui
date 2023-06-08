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
                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-600"
                    />
                    <label :for="option.value" class="block ml-3 text-sm font-medium leading-6 text-gray-900">{{ option.label }}</label>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script setup>
    const props = defineProps({
        options: Array
    });
</script>
