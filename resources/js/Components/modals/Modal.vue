<template>
    <div>
        <slot name="trigger" :open="open" />

        <Teleport to="body">
            <TransitionRoot as="template" :show="isOpen">
                <Dialog as="div" class="relative" @close="close">
                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="ease-in duration-200"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" />
                    </TransitionChild>

                    <div class="fixed inset-0 z-50 overflow-y-auto">
                        <form
                            class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0"
                            @submit.prevent="submit"
                        >
                            <TransitionChild
                                as="template"
                                enter="ease-out duration-300"
                                enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                enter-to="opacity-100 translate-y-0 sm:scale-100"
                                leave="ease-in duration-200"
                                leave-from="opacity-100 translate-y-0 sm:scale-100"
                                leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            >
                                <DialogPanel
                                    class="relative w-full overflow-hidden text-left transition-all transform bg-white divide-y divide-gray-100 rounded-lg shadow-xl sm:my-8 sm:max-w-lg"
                                >
                                    <button
                                        type="button"
                                        class="absolute text-gray-400 bg-white rounded-md top-4 right-4 hover:text-gray-500"
                                        @click="close"
                                    >
                                        <span class="sr-only" v-text="$t('close')" />

                                        <XIcon class="w-6 h-6" aria-hidden="true" />
                                    </button>

                                    <DialogTitle class="flex gap-4 px-4 py-3 sm:px-6">
                                        <h3 class="text-lg font-semibold text-gray-900" v-text="title" />
                                    </DialogTitle>

                                    <div class="flex flex-col gap-4 px-4 py-3 bg-white sm:px-6 sm:pb-6">
                                        <slot />
                                    </div>

                                    <div
                                        v-if="$slots.actions"
                                        class="flex gap-4 px-4 py-3 bg-gray-50 sm:flex-row-reverse ssm:justify-end sm:px-6"
                                    >
                                        <slot name="actions" :close="close" />
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </form>
                    </div>
                </Dialog>
            </TransitionRoot>
        </Teleport>
    </div>
</template>

<script setup>
    import { ref, nextTick } from 'vue';
    import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
    import { XIcon } from '@heroicons/vue/outline';

    const isOpen = ref(false);

    const props = defineProps({
        title: {
            type: String,
            required: true,
        },
        form: {
            type: Object,
            required: true,
        },
        formUrl: {
            type: String,
            required: true,
        },
        formMethod: {
            type: String,
            default: 'post',
        },
    });

    const emit = defineEmits(['submit']);

    const open = () => {
        isOpen.value = true;
    };

    const close = () => {
        isOpen.value = false;

        props.form.reset();
    };

    const submit = (event) => {
        props.form.submit(props.formMethod, props.formUrl, {
            preserveScroll: true,
            onSuccess: close,
        });
    };
</script>
