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
                        checked ? 'ring-inset ring-1 ring-turqoise-500' : 'ring-inset ring-1 ring-gray-300',
                        active ? 'ring-inset ring-1 ring-turqoise-500' : 'ring-inset ring-1 ring-gray-300',
                        'flex items-center justify-between gap-x-4 cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none'
                    ]"
                >
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ option.label }}</p>
                        <p class="text-sm font-medium text-gray-400">{{ option.description }}</p>
                    </div>

                    <SvgLoader v-if="!checked" name="circle" class="shrink-0 fill-white" />
                    <SvgLoader v-else name="checkmark" class="shrink-0" />
                </div>
            </RadioGroupOption>
        </div>
    </RadioGroup>
</template>

<script setup>
    /** Import plugins */
    import { RadioGroup, RadioGroupOption } from '@headlessui/vue';

    /** Import components. */
    import SvgLoader from '@/Components/SvgLoader.vue';

    const props = defineProps({
        options: Array,
        error: String,
    });
</script>
