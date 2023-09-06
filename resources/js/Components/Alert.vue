<template>
    <Teleport to="#alert-teleport-target">
        <transition
            enter-active-class="transition duration-300 ease-out transform"
            enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="show"
                class="w-full max-w-sm p-4 overflow-hidden bg-white rounded-lg shadow-lg pointer-events-auto ring-1 ring-black ring-opacity-5"
            >
                <div class="flex items-center gap-3">
                    <div class="shrink-0">
                        <ExclamationIcon v-if="'warning' === type" class="w-6 h-6 text-yellow-500" aria-hidden="true" />
                        <CheckCircleIcon v-if="'success' === type" class="w-6 h-6 text-green-500" aria-hidden="true" />
                        <XCircleIcon v-if="'error' === type" class="w-6 h-6 text-red-500" aria-hidden="true" />
                    </div>

                    <div class="flex-1 w-0">
                        <p class="text-sm font-medium text-gray-900" v-text="message" />
                    </div>
                </div>
            </div>
        </transition>
    </Teleport>
</template>

<script setup>
    /** Import form vue. */
    import { watchEffect, ref } from 'vue';

    /** Import plugins. */
    import { ExclamationIcon, XCircleIcon, CheckCircleIcon } from '@heroicons/vue/solid';

    /** Component props. */
    const props = defineProps({
        type: [String, Array, Boolean],
        message: String,
    });

    /** Local state. */
    const show = ref(false);

    /** Initialize emits. */
    const emit = defineEmits(['update:modelValue']);

    /** Show alert card. */
    watchEffect(() => {
        if (props.message) {
            show.value = true;

            setTimeout(() => {
                show.value = false;
                emit('emptyFlash', '');
            }, 3000);
        }
    });
</script>
