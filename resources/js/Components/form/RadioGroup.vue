<template>
    <RadioGroup>
        <div class="w-full space-y-6">
            <RadioGroupOption
                as="div"
                v-for="option in options"
                :key="option.value"
                :value="option.value"
                v-slot="{ checked, active }"
            >
                <div
                    :class="[
                        checked ? 'ring-inset ring-1 ring-primary-500' : 'ring-inset ring-1 ring-gray-300',
                        active ? 'ring-inset ring-1 ring-primary-500' : 'ring-inset ring-1 ring-gray-300',
                        'flex items-center justify-between gap-x-4 cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none',
                    ]"
                >
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ option.label }}</p>
                        <p class="text-sm font-medium text-gray-400">{{ option.description }}</p>
                    </div>

                    <CheckCircleIcon v-if="checked" class="w-5 h-5 shrink-0 text-primary-500" />
                    <span v-else class="w-5 h-5 border border-gray-300 rounded-full bg-gray-50 shrink-0" />
                </div>
            </RadioGroupOption>
        </div>
    </RadioGroup>
</template>

<script setup>
    /** Import plugins */
    import { RadioGroup, RadioGroupOption } from '@headlessui/vue';

    /** Import components. */
    import { CheckCircleIcon } from '@heroicons/vue/solid';

    const props = defineProps({
        options: Array,
        error: String,
    });
</script>
