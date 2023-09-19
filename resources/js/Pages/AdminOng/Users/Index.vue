<template>
    <DashboardLayout>
        <Title :title="$t('navigation.users')" :icon="UserCircleIcon" />

        <Modal
            triggerModalClasses="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
            :triggerModalText="$t('users.add_manager')"
            id="users.add_manager"
        >
            <form class="w-full space-y-4" @submit.prevent="addTicket">
                <h3 class="w-full text-lg font-semibold text-gray-900">
                    {{ $t('users.add_manager') }}
                </h3>

                <Input
                    class="w-full"
                    :label="$t('name_last_name')"
                    color="gray-700"
                    id="name"
                    type="text"
                    v-model="form.name"
                    :error="form.errors.name"
                    is-required
                />

                <Input
                    class="w-full"
                    :label="$t('email')"
                    id="email"
                    color="gray-700"
                    v-model="form.email"
                    :error="form.errors.email"
                    is-required
                />

                <!-- Actions -->
                <div class="flex items-center justify-end w-full gap-6 pt-6">
                    <SecondaryButton @click="closeModal" class="py-2.5">
                        {{ $t('cancel') }}
                    </SecondaryButton>

                    <PrimaryButton background="primary-500" hover="primary-400" color="white" class="w-auto">
                        {{ $t('add') }}
                    </PrimaryButton>
                </div>
            </form>
        </Modal>

        <Table :collection="collection">
            <template #role="{ role }">
                {{ role.label }}
            </template>

            <template #actions="{ row }">
                <ModalAction
                    v-if="row.role.value !== 'admin'"
                    triggerModalClasses="block text-sm font-medium leading-5 text-red-600 hover:underline"
                    :triggerModalText="$t('delete')"
                    :cancelModalText="$t('cancel')"
                    :actionModalText="$t('delete')"
                    :title="$t('confirm')"
                    :body="`${$t('confirm_delete_text')} ${row.name}`"
                    :actionRoute="route('dashboard.volunteers.delete', row.id)"
                    actionType="delete"
                />
            </template>
        </Table>
    </DashboardLayout>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';

    import DashboardLayout from '@/Layouts/DashboardLayout.vue';
    import Pagination from '@/Components/pagination/Pagination.vue';
    import Title from '@/Components/Title.vue';
    import Table from '@/Components/tables/Table.vue';
    import Modal from '@/Components/modals/Modal.vue';
    import ModalAction from '@/Components/modals/ModalAction.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import Input from '@/Components/form/Input.vue';

    import { UserCircleIcon } from '@heroicons/vue/outline';

    const props = defineProps({
        status: {
            type: String,
        },
        collection: {
            type: Object,
        },
    });

    const form = useForm({
        name: null,
        email: null,
    });
</script>
