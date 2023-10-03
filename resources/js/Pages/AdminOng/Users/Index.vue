<template>
    <DashboardLayout>
        <Title :title="$t('navigation.users')" :icon="UserCircleIcon" />

        <Modal
            v-if="collection.can.create"
            :title="$t('users.add_manager')"
            :form="form"
            :formUrl="route('dashboard.users.store')"
        >
            <template #trigger="{ open }">
                <SecondaryButton @click="open" :label="$t('users.add_manager')" />
            </template>

            <Input
                class="w-full"
                :label="$t('name_last_name')"
                color="gray-700"
                type="text"
                v-model="form.name"
                :error="form.errors.name"
                is-required
            />

            <Input
                class="w-full"
                :label="$t('email')"
                type="email"
                color="gray-700"
                v-model="form.email"
                :error="form.errors.email"
                is-required
            />

            <template #actions="{ close }">
                <PrimaryButton type="submit" :label="$t('add')" />

                <SecondaryButton @click="close" class="py-2.5" :label="$t('cancel')" />
            </template>
        </Modal>

        <Table :collection="collection">
            <template #actions="{ row }">
                <ConfirmationModal
                    v-if="row.can.delete && !row.is_admin"
                    :title="$t('users.remove.title')"
                    :content="$t('users.remove.content', { name: row.name })"
                    :trigger="$t('delete')"
                    :confirmActionUrl="route('dashboard.users.destroy', row.id)"
                    confirmActionMethod="delete"
                    color="danger"
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
    import ConfirmationModal from '@/Components/modals/ConfirmationModal.vue';
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
