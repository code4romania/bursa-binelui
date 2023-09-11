<template>
    <div>
        <button @click="open = !open" class="block text-sm font-medium text-danger-500">
            <span v-if="ticket.is_open" v-text="$t('close_ticket')" />
            <span v-else v-text="$t('reopen_ticket')" />
        </button>

        <Teleport to="body">
            <TransitionRoot as="template" :show="open">
                <Dialog as="div" class="relative z-101" @close="open = false">
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

                    <div class="fixed inset-0 z-10 overflow-y-auto">
                        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
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
                                    <div>
                                        <div
                                            class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full"
                                        >
                                            <CheckIcon class="w-6 h-6 text-green-500" aria-hidden="true" />
                                        </div>

                                        <div class="mt-3 text-center sm:mt-5">
                                            <DialogTitle
                                                as="h3"
                                                class="text-base font-semibold leading-6 text-gray-900"
                                            >
                                                {{ $t('confirm') }}
                                            </DialogTitle>

                                            <p
                                                class="mt-2 text-sm text-gray-500"
                                                v-if="ticket.is_open"
                                                v-text="$t('confirm_close_ticket')"
                                            />
                                            <p
                                                class="mt-2 text-sm text-gray-500"
                                                v-else
                                                v-text="$t('confirm_reopen_ticket')"
                                            />
                                        </div>
                                    </div>
                                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                        <button
                                            type="button"
                                            class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0"
                                            @click="open = false"
                                        >
                                            {{ $t('cancel') }}
                                        </button>

                                        <button
                                            @click="action"
                                            type="button"
                                            class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white rounded-md shadow-sm bg-primary-500 hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-500 sm:col-start-2"
                                        >
                                            <span v-if="ticket.is_open" v-text="$t('close_ticket')" />
                                            <span v-else v-text="$t('reopen_ticket')" />
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
    import { ref, computed } from 'vue';

    /** Import from inertia */
    import { useForm } from '@inertiajs/vue3';

    /** Import plugins. */
    import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
    import { CheckIcon } from '@heroicons/vue/outline';

    /** Component props. */
    const props = defineProps({
        ticket: Object,
    });

    /** Local state. */
    const open = ref(false);

    const form = useForm({});

    /** Delete action. */
    const action = () => {
        open.value = false;

        form.post(route('dashboard.tickets.status', props.ticket.id), {
            preserveScroll: true,
            onFinish: () => {
                open.value = false;
            },
        });
    };
</script>
