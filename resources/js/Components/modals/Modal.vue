<template>
    <div>
        <button
            :id="id"
            @click="open = !open"
            :class="triggerModalClasses"
        >
            {{ triggerModalText }}
        </button>

        <Teleport to="body">
            <TransitionRoot as="template" :show="open">
                <Dialog as="div" class="relative z-50" @close="open = false">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" />
                    </TransitionChild>

                    <div class="fixed inset-0 z-50 overflow-y-auto">
                        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                <DialogPanel
                                    :class="[
                                        dialogClasses ? `${dialogClasses}` : 'bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-lg sm:p-6',
                                        'relative px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform'
                                        ]"
                                    >
                                    <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                                        <button :id="closeId" type="button" class="text-gray-400 bg-white rounded-md hover:text-gray-500" @click="open = false">
                                            <span class="sr-only">Close</span>
                                            <XMarkIcon class="w-6 h-6" aria-hidden="true" />
                                        </button>
                                    </div>
                                    <div class="sm:flex sm:items-start">
                                        <slot />
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>
        </Teleport>
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
    import { XMarkIcon } from '@heroicons/vue/24/outline';

    const open = ref(false);

    /** Component props. */
    const props = defineProps({
        triggerModalText: String,
        triggerModalClasses: String,
        id: {
            type: String,
            default: ''
        },
        closeId: {
            type: String,
            default: ''
        },
        dialogClasses: {
            type: String,
            default: ''
        }
    });
</script>
