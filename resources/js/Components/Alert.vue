<template>
    <transition name="fade">
        <div v-if="show" :class="['border-l-4 p-4', 'success' == type ? 'border-green-400 bg-green-50' : 'error' == type ? 'border-red-400 bg-red-50' : 'border-yellow-400 bg-yellow-50']">
            <div class="flex">

                <div class="flex-shrink-0">
                    <ExclamationTriangleIcon v-if="'warning' == type" class="h-5 w-5 text-yellow-700" aria-hidden="true" />
                    <CheckCircleIcon v-if="'success' == type" class="h-5 w-5 text-green-700" aria-hidden="true" />
                    <XCircleIcon v-if="'error' == type" class="h-5 w-5 text-red-700" aria-hidden="true" />
                </div>

                <div class="ml-3">
                    <p
                        :class="[`text-sm font-medium`, 'success' == type ? 'text-green-800' : 'error' == type ? 'text-red-800' : 'text-yellow-700']"
                    >
                        {{ message }}
                    </p>
                </div>
            </div>
        </div>
    </transition>
</template>

<script setup>
    /** Import form vue. */
    import { watchEffect, ref } from 'vue'

    /** Import plugins. */
    import { ExclamationTriangleIcon, XCircleIcon, CheckCircleIcon } from '@heroicons/vue/20/solid';

    /** Component props. */
    const props = defineProps({
        type: [String, Array],
        message: String
    });

    /** Local state. */
    const show = ref(false);

    /** Initialize emits. */
    const emit = defineEmits(['update:modelValue']);

    /** Show alert card. */
    watchEffect(() => {
        if (props.message) {
            show.value = true

            setTimeout(() => {
                show.value = false
                emit('emptyFlash', '')
            }, 3000)
        }
    })
</script>

<style scoped>
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.5s;
    }

    .fade-enter,
    .fade-leave-to {
        opacity: 0;
    }
</style>
