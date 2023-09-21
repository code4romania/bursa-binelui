<template>
    <Teleport to="#notification-teleport-target">
        <transition
            enter-active-class="transition duration-300 ease-out transform"
            enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="isVisible"
                class="w-full max-w-sm p-4 overflow-hidden bg-white rounded-lg shadow-lg pointer-events-auto ring-1 ring-black ring-opacity-5"
            >
                <div class="flex items-center gap-3">
                    <Component
                        :is="isSuccess ? CheckCircleIcon : ExclamationCircleIcon"
                        class="w-6 h-6 shrink-0"
                        :class="{
                            'text-green-500': isSuccess,
                            'text-red-500': !isSuccess,
                        }"
                        aria-hidden="true"
                    />

                    <div class="flex-1 w-0">
                        <p class="text-sm font-medium text-gray-900" v-text="message" />
                    </div>

                    <button
                        type="button"
                        @click="hide"
                        class="inline-flex text-gray-400 bg-white rounded-md shrink-0 hover:text-gray-500"
                    >
                        <span class="sr-only">Close</span>
                        <XIcon class="w-5 h-5" aria-hidden="true" />
                    </button>
                </div>
            </div>
        </transition>
    </Teleport>
</template>

<script setup>
    import { ref, computed, watch, nextTick } from 'vue';
    import { usePage } from '@inertiajs/vue3';
    import { ExclamationCircleIcon, CheckCircleIcon, XIcon } from '@heroicons/vue/solid';

    const isSuccess = computed(() => new Boolean(usePage().props.flash?.success));
    const message = computed(() => usePage().props.flash?.message || null);

    const isVisible = ref(false);
    const show = () => (isVisible.value = true);
    const hide = () => (isVisible.value = false);

    watch(message, (message) => {
        if (!message) {
            hide();
        } else {
            show();

            setTimeout(hide, 5000);
        }
    });
</script>
