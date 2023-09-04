<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="isOpen ? $t('open_tickets') : $t('closed_tickets')" />

        <!-- Alert -->
        <Alert
            class="fixed z-50 right-10 top-10 w-96"
            :type="flash.error_message ? 'error' : flash.success_message ? 'success' : false"
            :message="flash.success_message || flash.error_message"
            @emptyFlash="Object.assign(flash, { success_message: '', error_message: '' })"
        />

        <!-- Dashboard template -->
        <Dashboard>
            <div class="w-full mb-24 space-y-8 p-9">
                <div class="flex flex-wrap">
                    <Link
                        :href="route('admin.ong.tickets.index', { status: 'open' })"
                        :class="[
                            'py-2.5 px-3.5 text-sm font-semibold',
                            route().current('admin.ong.tickets.index', {
                                status: 'open',
                            })
                                ? 'bg-primary-500 text-white'
                                : 'bg-primary-50 text-primary-500',
                        ]"
                    >
                        {{ $t('open_tickets') }}
                    </Link>

                    <Link
                        :href="
                            route('admin.ong.tickets.index', {
                                status: 'closed',
                            })
                        "
                        :class="[
                            'py-2.5 px-3.5 text-sm font-semibold',
                            route().current('admin.ong.tickets.index', {
                                status: 'closed',
                            })
                                ? 'bg-primary-500 text-white'
                                : 'bg-primary-50 text-primary-500',
                        ]"
                    >
                        {{ $t('closed_tickets') }}
                    </Link>
                </div>

                <div v-if="isOpen">
                    <Modal
                        triggerModalClasses="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                        :triggerModalText="$t('add_ticket')"
                        id="add_ticket"
                    >
                        <form class="w-full space-y-4" @submit.prevent="addTicket">
                            <h3 class="w-full text-lg font-semibold text-gray-900">
                                {{ $t('add_ticket') }}
                            </h3>

                            <Input
                                class="w-full"
                                :label="$t('subject')"
                                color="gray-700"
                                id="subject"
                                type="text"
                                v-model="form.subject"
                                :error="form.errors.subject"
                                is-required
                            />

                            <Textarea
                                class="w-full"
                                :label="$t('message')"
                                id="content"
                                color="gray-700"
                                v-model="form.content"
                                :error="form.errors.content"
                                is-required
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
                                    {{ $t('send') }}
                                </PrimaryButton>
                            </div>
                        </form>
                    </Modal>
                </div>

                <header class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                        <SvgLoader class="shrink-0 fill-primary-500" name="annotation" />
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ isOpen ? $t('open_tickets') : $t('closed_tickets') }}
                    </h1>
                </header>

                <Table
                    class="mb-24"
                    :columns="
                        isOpen
                            ? ['ID', $t('ticket_subject'), $t('ticket_created_at')]
                            : ['ID', $t('ticket_subject'), $t('ticket_closed_at')]
                    "
                    :resource="tickets"
                >
                    <tr v-for="(ticket, index) in tickets.data" :key="index">
                        <td class="w-8 px-3 py-4 overflow-hidden text-sm text-right text-gray-500 text-ellipsis">
                            #{{ ticket.id }}
                        </td>
                        <td class="w-8/12 max-w-lg px-3 py-4 overflow-hidden text-sm text-gray-500 text-ellipsis">
                            {{ ticket.subject }}
                        </td>
                        <td class="w-1/12 px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ isOpen ? ticket.created_at : ticket.closed_at }}
                        </td>

                        <td
                            class="relative flex items-center justify-end gap-4 py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6"
                        >
                            <Link
                                class="block text-sm font-medium text-blue-500 leadin-5"
                                :href="route('admin.ong.tickets.view', ticket.id)"
                            >
                                {{ $t('view') }}
                            </Link>
                        </td>
                    </tr>
                </Table>
            </div>
        </Dashboard>
    </PageLayout>
</template>

<script setup>
    import { computed } from 'vue';

    /** Import from inertia. */
    import { Head, Link, useForm } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Dashboard from '@/Components/templates/Dashboard.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Alert from '@/Components/Alert.vue';
    import Table from '@/Components/templates/Table.vue';
    import ModalAction from '@/Components/modals/ModalAction.vue';
    import Modal from '@/Components/modals/Modal.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import Textarea from '@/Components/form/Textarea.vue';
    import Input from '@/Components/form/Input.vue';

    const flash = {
        success_message: '',
        error_message: '',
    };

    const form = useForm({
        subject: '',
        content: '',
    });

    const props = defineProps({
        status: {
            type: String,
        },
        tickets: {
            type: Object,
        },
    });

    const closeModal = () => document.getElementById('add_ticket').click();

    const addTicket = () => {
        form.post(route('admin.ong.tickets.store'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
            },
        });
    };

    const isOpen = computed(() => props.status === 'open');
</script>
