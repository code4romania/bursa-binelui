<template>
    <div>
        <button
            @click="open = !open"
            class="block text-sm font-medium text-blue-500"
        >
            {{ $t('edit') }}
        </button>

        <Teleport to="body">
            <TransitionRoot as="template" :show="open">
                <Dialog as="div" class="relative z-50" @close="open = false">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                    </TransitionChild>

                    <div class="fixed inset-0 z-10 overflow-y-auto">
                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl lg:max-w-5xl sm:p-6">
                                    <div>
                                        <div class="mt-3 sm:mt-5">
                                            <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">
                                                {{ $t('edit') }}
                                            </DialogTitle>
                                            <div class="mt-2">
                                                <slot />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5 sm:mt-6 flex items-center justify-end gap-6">

                                        <button type="button" class="mt-3 inline-flex justify-center rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0" @click="open = false">
                                            {{ $t('cancel') }}
                                        </button>

                                        <button
                                            @click="$emit('action', $event.target.value)"
                                            type="button"
                                            class="inline-flex justify-center rounded-md bg-turqoise-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-turqoise-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-turqoise-500 sm:col-start-2"
                                        >
                                            {{ $t('save') }}
                                        </button>
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
    /** Import from vue. */
    import { ref } from 'vue';

    /** Import plugins. */;
    import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
    import { CheckIcon } from '@heroicons/vue/24/outline';

    /** Local state. */
    const open = ref(false);

    /** Initialize emits. */
    const emit = defineEmits(['action']);
</script>
