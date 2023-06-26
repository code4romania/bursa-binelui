<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('open_tickets')" />

        <!-- Alert -->
        <Alert
            class="fixed right-10 top-10 w-96 z-50"
            :type="flash.error_message ? 'error' : flash.success_message ? 'success' : false"
            :message="flash.success_message || flash.error_message"
            @emptyFlash="Object.assign(flash, { success_message:'', error_message:'' });"
        />

        <!-- Dashboard template -->
        <Dashboard>
           <div class="p-9 mb-24 w-full">
                <div class="flex flex-wrap">
                    <Link
                        :href="route('admin.ong.tickets.open')"
                        :class="['py-2.5 px-3.5 text-sm font-semibold', route().current('admin.ong.tickets.open') ? 'bg-primary-500 text-white' : 'bg-primary-50 text-primary-500']"
                    >
                        {{ $t('open_tickets') }}
                    </Link>

                    <Link
                        :href="route('admin.ong.tickets.closed')"
                        :class="['py-2.5 px-3.5 text-sm font-semibold', route().current('admin.ong.tickets.closed') ? 'bg-primary-500 text-white' : 'bg-primary-50 text-primary-500']"
                    >
                        {{ $t('closed_tickets') }}
                    </Link>
                </div>

                <div>
                    <Modal
                        triggerModalClasses="rounded-md bg-white px-3.5 py-2.5 my-6 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                        :triggerModalText="$t('add_ticket')"
                        id="add_ticket"
                    >
                        <form class="space-y-4 w-full" @submit.prevent="addTicket">

                            <h3 class="w-full text-gray-900 font-semibold text-lg">{{ $t('add_ticket') }}</h3>

                            <Input
                                class="w-full"
                                :label="$t('subject')"
                                color="gray-700"
                                id="subject"
                                type="text"
                                v-model="form.subject"
                            />

                            <Textarea
                                class="w-full"
                                :label="$t('message')"
                                id="message"
                                color="gray-700"
                                v-model="form.message"
                            />

                            <!-- Actions -->
                            <div class="pt-6 w-full flex items-center justify-end gap-6">
                                <SecondaryButton
                                    @click="closeModal"
                                    class="py-2.5"
                                >
                                    {{ $t('cancel') }}
                                </SecondaryButton>

                                <PrimaryButton
                                    background="turqoise-500"
                                    hover="turqoise-400"
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
                    <div class="bg-primary-500 w-8 h-8 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0 fill-primary-500" name="annotation"/>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $t('open_tickets') }}</h1>
                </header>

                <Table
                    class="mb-24"
                    :columns="columns"
                    :currentPage="tickets.current_page"
                    :prev="tickets.prev_page_url"
                    :next="tickets.next_page_url"
                    :links="tickets.links"
                >
                    <tr v-for="(ticket, index) in tickets.data" :key="index">
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 w-8/12">{{ ticket.subject }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 w-1/12">{{ ticket.date }}</td>

                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 flex items-center justify-end gap-4">
                            <Link
                                class="block text-sm font-medium leadin-5 text-blue-500"
                                :href="route('admin.ong.tickets.view', ticket.id)"
                            >
                                {{ $t('view') }}
                            </Link>

                            <ModalAction
                                triggerModalClasses="block text-sm font-medium leadin-5 text-blue-500"
                                :triggerModalText="$t('close')"
                                :cancelModalText="$t('cancel')"
                                :actionModalText="$t('close')"
                                :title="$t('confirm')"
                                :body="`${$t('confirm_reject_text')} ${ticket.subject}`"
                                actionRoute="route('admin.client.destroy', ticket.user.id)"
                                :data="ticket"
                            />
                        </td>
                    </tr>
                </Table>
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
        success_message:'',
        error_message:''
    }

    const form = useForm({
        subject: '',
        message: ''
    })

    const columns = ['Subiect', 'Data'];

    const closeModal =(() => document.getElementById('add_ticket').click());

    const addTicket = () => {

    }

    const tickets = {
        "current_page": 2,
        "data": [
            {
                id: 1,
                subject: 'Subiect',
                date: '12.08.2022',
                message: "Mesaj"
            },
        ],
        "first_page_url": "http://bursabinelui.test/proiecte?page=1",
        "from": 1,
        "last_page": 2,
        "last_page_url": "http://bursabinelui.test/proiecte?page=2",
        "links": [
            {
                "url": "http://bursabinelui.test/proiecte?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": "http://bursabinelui.test/proiecte?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": "http://bursabinelui.test/proiecte?page=2",
                "label": "2",
                "active": false
            },
            {
                "url": "http://bursabinelui.test/proiecte?page=3",
                "label": "3",
                "active": false
            },
            {
                "url": "http://bursabinelui.test/proiecte?page=1",
                "label": "1",
                "active": true
            },
        ],
        "next_page_url": "http://bursabinelui.test/proiecte?page=3",
        "path": "http://bursabinelui.test/proiecte",
        "per_page": 15,
        "prev_page_url": 'http://bursabinelui.test/proiecte?page=1',
        "to": 15,
        "total": 20
    }
</script>
