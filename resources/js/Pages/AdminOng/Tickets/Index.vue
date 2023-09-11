<template>
    <DashboardLayout>
        <div class="flex flex-wrap">
            <Link
                :href="route('dashboard.tickets.index', { status: 'open' })"
                :class="[
                    'py-2.5 px-3.5 text-sm font-semibold',
                    route().current('dashboard.tickets.index', {
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
                    route('dashboard.tickets.index', {
                        status: 'closed',
                    })
                "
                :class="[
                    'py-2.5 px-3.5 text-sm font-semibold',
                    route().current('dashboard.tickets.index', {
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

                        <PrimaryButton background="primary-500" hover="primary-400" color="white" class="w-auto">
                            {{ $t('send') }}
                        </PrimaryButton>
                    </div>
                </form>
            </Modal>
        </div>

        <Title :title="isOpen ? $t('open_tickets') : $t('closed_tickets')">
            <AnnotationIcon />
        </Title>

        <Table class="mb-24" :collection="collection">
            <template #id="{ id }"> #{{ id }} </template>

            <template #actions="{ row }">
                <Link class="text-sm font-medium text-primary-600" :href="route('dashboard.tickets.view', row.id)">
                    {{ $t('view') }}
                </Link>
            </template>
        </Table>
    </DashboardLayout>
</template>

<script setup>
    import { computed } from 'vue';

    /** Import from inertia. */
    import { useForm } from '@inertiajs/vue3';

    /** Import components. */
    import DashboardLayout from '@/Layouts/DashboardLayout.vue';
    import Title from '@/Components/Title.vue';
    import Table from '@/Components/tables/Table.vue';
    import ModalAction from '@/Components/modals/ModalAction.vue';
    import Modal from '@/Components/modals/Modal.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import Textarea from '@/Components/form/Textarea.vue';
    import Input from '@/Components/form/Input.vue';

    import { AnnotationIcon } from '@heroicons/vue/outline';

    const form = useForm({
        subject: '',
        content: '',
    });

    const props = defineProps({
        status: {
            type: String,
        },
        collection: {
            type: Object,
        },
    });

    const closeModal = () => document.getElementById('add_ticket').click();

    const addTicket = () => {
        form.post(route('dashboard.tickets.store'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
            },
        });
    };

    const isOpen = computed(() => props.status === 'open');
</script>
