<template>
    <div>
        <button
            type="button"
            @click="open"
            class="block text-sm font-medium leading-5 hover:underline"
            :class="triggerColor"
            v-text="trigger"
        />

        <ClientOnly>
            <Teleport to="#notification-teleport-target">
                <TransitionRoot as="template" :show="isOpen">
                    <Dialog as="div" class="relative z-10" @close="close">
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

                        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                            <div
                                class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0"
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
                                        class="relative px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                                    >
                                        <div class="sm:flex sm:items-start">
                                            <div
                                                class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto rounded-full sm:mx-0 sm:h-10 sm:w-10"
                                                :class="iconColor"
                                            >
                                                <component :is="icon" class="w-6 h-6" aria-hidden="true" />
                                            </div>
                                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                                <DialogTitle
                                                    as="h3"
                                                    class="text-base font-semibold leading-6 text-gray-900"
                                                >
                                                    {{ title }}
                                                </DialogTitle>

                                                <div class="mt-2 text-sm text-gray-500">
                                                    <slot name="content">
                                                        {{ content }}
                                                    </slot>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                            <button
                                                type="button"
                                                class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold rounded-md shadow-sm sm:ml-3 sm:w-auto"
                                                :class="buttonColor"
                                                @click="confirm"
                                                v-text="confirmActionLabel || trigger"
                                            />

                                            <button
                                                type="button"
                                                class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                                @click="close"
                                                ref="cancelButtonRef"
                                                v-text="cancelActionLabel || $t('cancel')"
                                            />
                                        </div>
                                    </DialogPanel>
                                </TransitionChild>
                            </div>
                        </div>
                    </Dialog>
                </TransitionRoot>
            </Teleport>
        </ClientOnly>
    </div>
</template>

<script setup>
    import { computed, ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
    import { ExclamationIcon } from '@heroicons/vue/outline';
    import ClientOnly from '@/Components/ClientOnly.vue';

    const props = defineProps({
        title: {
            type: String,
            required: true,
        },
        content: {
            type: String,
            default: null,
        },
        trigger: {
            type: String,
            required: true,
        },
        icon: {
            type: Function,
            default: ExclamationIcon,
        },
        color: {
            type: String,
            default: 'primary',
            validator: (color) => ['primary', 'success', 'danger', 'warning'].includes(color),
        },
        confirmActionLabel: {
            type: String,
            default: null,
        },
        cancelActionLabel: {
            type: String,
            default: null,
        },
        confirmActionUrl: {
            type: String,
            required: true,
        },
        confirmActionMethod: {
            type: String,
            default: 'post',
            validator: (method) => ['post', 'put', 'delete'].includes(method),
        },
        confirmActionPayload: {
            type: Object,
            default: () => ({}),
        },
    });

    const triggerColor = computed(
        () =>
            ({
                primary: 'text-primary-600',
                success: 'text-success-600',
                danger: 'text-danger-600',
                warning: 'text-warning-600',
            }[props.color])
    );

    const iconColor = computed(
        () =>
            ({
                primary: 'bg-primary-100 text-primary-600',
                success: 'bg-success-100 text-success-600',
                danger: 'bg-danger-100 text-danger-600',
                warning: 'bg-warning-100 text-warning-600',
            }[props.color])
    );

    const buttonColor = computed(
        () =>
            ({
                primary: 'text-white bg-primary-500 hover:bg-primary-400',
                success: 'text-white bg-success-500 hover:bg-success-400',
                danger: 'text-white bg-danger-500 hover:bg-danger-400',
                warning: 'text-white bg-warning-500 hover:bg-warning-400',
            }[props.color])
    );

    const emit = defineEmits(['confirm']);

    const isOpen = ref(false);

    const open = () => {
        isOpen.value = true;
    };

    const close = () => {
        isOpen.value = false;
    };

    const confirm = () => {
        useForm(props.confirmActionPayload).submit(props.confirmActionMethod, props.confirmActionUrl);

        close();
    };
</script>
