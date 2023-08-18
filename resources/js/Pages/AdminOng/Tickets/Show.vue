<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('ticket')" />

        <!-- Alert -->
        <Alert
            class="fixed right-10 top-10 w-96"
            :type="flash.error_message ? 'error' : flash.success_message ? 'success' : false"
            :message="flash.success_message || flash.error_message"
            @emptyFlash="Object.assign(flash, { success_message: '', error_message: '' })"
        />

        <!-- Dashboard template -->
        <Dashboard>
            <div class="w-full mb-24 p-9">
                <header class="flex gap-4">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500 shrink-0">
                        <SvgLoader class="shrink-0 fill-primary-500" name="annotation" />
                    </div>
                    <h1 class="overflow-hidden text-2xl font-bold text-gray-900 text-ellipsis">
                        {{ $t('ticket') }} #{{ ticket.id }}: {{ ticket.subject }}
                    </h1>
                </header>

                <dl class="my-8 divide-y divide-gray-200">
                    <div class="grid px-4 py-3 text-gray-700 md:grid-cols-12">
                        <dt class="font-semibold md:col-span-5 lg:col-span-3">ID</dt>
                        <dt class="text-sm md:col-span-6 lg:col-span-8" v-text="ticket.id" />
                    </div>
                    <div class="grid px-4 py-3 text-gray-700 md:grid-cols-12">
                        <dt class="font-semibold md:col-span-5 lg:col-span-3" v-text="$t('date')" />
                        <dt class="text-sm md:col-span-6 lg:col-span-8" v-text="ticket.created_at" />
                    </div>

                    <div class="grid px-4 py-3 text-gray-700 md:grid-cols-12">
                        <dt class="font-semibold md:col-span-5 lg:col-span-3" v-text="$t('message')" />
                        <dt class="text-sm break-words md:col-span-6 lg:col-span-8" v-text="ticket.content" />
                    </div>
                </dl>

                <dl class="my-8 border border-gray-100 divide-y divide-gray-50">
                    <div
                        v-for="(message, index) in ticket.messages"
                        :key="index"
                        class="grid grid-cols-12 px-4 py-3 text-sm"
                        :class="{
                            'bg-gray-50': index % 2 === 0,
                            'outline-dashed outline-1 outline-warning-500 shadow bg-warning-50': isMessageHighlighted(
                                message
                            ),
                        }"
                        :id="`reply-${message.id}`"
                    >
                        <dt class="col-span-12 leading-none text-gray-700 md:col-span-5 lg:col-span-3">
                            <p
                                class="text-sm font-semibold"
                                :class="{
                                    'text-warning-600': message.user.is_bb_admin,
                                }"
                                v-text="message.user.name"
                            />

                            <time
                                class="text-xs text-gray-500"
                                :datetime="message.created_at"
                                :title="message.created_at"
                                v-text="message.created_at_relative"
                            />
                        </dt>
                        <dt class="col-span-12 md:col-span-6 lg:col-span-8" v-text="message.content" />
                    </div>
                </dl>

                <div class="flex items-center justify-end w-full gap-4 mt-8">
                    <Modal
                        triggerModalClasses="whitespace-nowrap px-3 py-4 text-sm text-blue-500"
                        :triggerModalText="$t('answer')"
                        id="ticket-answer"
                        v-if="ticket.is_open"
                    >
                        <form class="w-full space-y-4" @submit.prevent="reply">
                            <h3>
                                <span class="block text-lg font-semibold to-gray-900">
                                    {{ $t('ticket_reply_header') }}
                                </span>
                                <span class="block text-base text-gray-500">{{ ticket.subject }}</span>
                            </h3>

                            <Textarea
                                class="w-full"
                                :label="$t('message')"
                                id="project-scope"
                                color="gray-700"
                                v-model="form.content"
                            />

                            <!-- Actions -->
                            <div class="flex items-center justify-end w-full gap-6 pt-6">
                                <SecondaryButton @click="closeModal" class="py-2.5">
                                    {{ $t('cancel') }}
                                </SecondaryButton>

                                <PrimaryButton
                                    background="primary-500"
                                    hover="primary-400"
                                    color="white"
                                    class="w-auto"
                                >
                                    {{ $t('save') }}
                                </PrimaryButton>
                            </div>
                        </form>
                    </Modal>

                    <ToggleTicketStatusModal :ticket="ticket" />
                </div>
            </div>
        </Dashboard>
    </PageLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { Head, Link, useForm } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Dashboard from '@/Components/templates/Dashboard.vue';
    import Alert from '@/Components/Alert.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import ToggleTicketStatusModal from '@/Components/modals/ToggleTicketStatusModal.vue';
    import Modal from '@/Components/modals/Modal.vue';
    import Textarea from '@/Components/form/Textarea.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    const props = defineProps({
        ticket: {
            type: Object,
        },
        flash: {
            type: Object,
            default: () => ({
                success_message: '',
                error_message: '',
            }),
        },
    });

    const form = useForm({
        content: '',
    });

    const isMessageHighlighted = (message) => window.location.hash === `#reply-${message.id}`;

    const closeModal = () => document.getElementById('ticket-answer').click();

    const reply = () => {
        closeModal();
        form.post(route('admin.ong.tickets.reply', props.ticket.id), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
            },
        });
    };
</script>
