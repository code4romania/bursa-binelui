<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('ticket')" />

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
                <header class="flex items-center gap-4">
                    <div class="bg-primary-500 w-8 h-8 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0 fill-primary-500" name="annotation"/>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ ticket.subject }}</h1>
                </header>

                <div class="mt-6 border-t border-gray-100">
                    <dl class="divide-y divide-gray-100">

                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('date') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ ticket.date }}</dt>
                        </div>

                        <!-- Edit project name -->
                        <div class="bg-white px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('subject') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ ticket.subject }}</dt>
                        </div>

                        <!-- Edit target amount -->
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('message') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ ticket.message }}</dt>
                        </div>

                        <div
                            v-for="(message, index) in messages"
                            :key="index"
                            :class="[index % 2 == 0 ? 'bg-white': 'bg-gray-100', 'px-4 py-6 grid grid-cols-12']"
                        >
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">
                                <p class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ message.owner }}</p>
                                <p class="col-span-12 md:col-span-5 text-sm leading-5 text-gray-700">{{ message.date }}</p>
                            </dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ message.message }}</dt>
                        </div>

                    </dl>
                </div>

                <div class="w-full mt-8 flex items-center justify-end gap-4">
                    <Modal
                        triggerModalClasses="whitespace-nowrap px-3 py-4 text-sm text-blue-500"
                        :triggerModalText="$t('answer')"
                        id="ticket-answer"
                    >
                        <form class="space-y-4 w-full" @submit.prevent="editDonation">

                            <h3 class="w-full text-gray-900 font-semibold text-lg">{{ ticket.subject }}</h3>

                            <Textarea
                                class="w-full"
                                :label="$t('message')"
                                id="project-scope"
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

                    <ModalAction
                        triggerModalClasses="block text-sm font-medium leadin-5 text-blue-500"
                        :triggerModalText="$t('close_ticket')"
                        :cancelModalText="$t('cancel')"
                        :actionModalText="$t('close')"
                        :title="$t('confirm')"
                        :body="`${$t('confirm_reject_text')} ${ticket.subject}`"
                        actionRoute="route('admin.client.destroy', ticket.user.id)"
                        :data="ticket"
                    />
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
    import ModalAction from '@/Components/modals/ModalAction.vue';
    import Modal from '@/Components/modals/Modal.vue';
    import Textarea from '@/Components/form/Textarea.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    const flash = {
        success_message:'',
        error_message:''
    }

    const ticket = {
        id: 1,
        subject: 'Subiect ticket',
        date: '12.08.2022',
        message: 'mesaj ticket'
    };

    const form = useForm({
        message: ''
    });

    const closeModal =(() => document.getElementById('ticket-answer').click());

    const messages = [
        {
            id: 1,
            owner: 'Client',
            subject: 'Subiect ticket',
            date: '12.08.2022',
            message: 'mesaj ticket 1'
        },
        {
            id: 2,
            owner: 'Admin',
            subject: 'Subiect ticket',
            date: '12.08.2022',
            message: 'mesaj ticket 2'
        },
        {
            id: 3,
            owner: 'Admin',
            subject: 'Subiect ticket',
            date: '12.08.2022',
            message: 'mesaj ticket 3'
        },
        {
            id: 4,
            owner: 'Admin',
            subject: 'Subiect ticket',
            date: '12.08.2022',
            message: 'mesaj ticket 4'
        }
    ]
</script>
