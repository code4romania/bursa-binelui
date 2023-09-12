<template>
    <DashboardLayout>
        <Title v-if="status === 'pending'" :title="$t('new_volunteer_requests')" :icon="UserAddIcon" />

        <Title v-else-if="status === 'rejected'" :title="$t('rejected_requests')" :icon="UserRemoveIcon" />

        <Title v-else :title="$t('my_volunteers')" :icon="UserGroupIcon" />

        <Table :collection="collection">
            <template #name="{ name, row }">
                <div class="flex items-center gap-2">
                    <img v-if="row?.user?.image" :src="row.user.image" class="w-10 h-10 rounded-full" alt="" />
                    <UserCircleIcon v-else class="w-12 h-12 text-gray-300 shrink-0" />

                    <div>
                        <p class="text-sm font-medium text-gray-900" v-text="name" />
                        <p class="text-sm text-gray-500" v-text="row.email" />
                    </div>
                </div>
            </template>

            <template #has_user="{ has_user }">
                {{ has_user ? $t('yes') : $t('no') }}
            </template>

            <template #actions="{ row }">
                <ModalAction
                    v-if="status === 'pending'"
                    triggerModalClasses="block text-sm font-medium leading-5 text-blue-600 hover:underline "
                    :triggerModalText="$t('accept')"
                    :cancelModalText="$t('cancel')"
                    :actionModalText="$t('accept')"
                    :title="$t('confirm')"
                    :body="`${$t('confirm_accept_text')} ${row.name}`"
                    :actionRoute="route('dashboard.volunteers.approve', row.id)"
                    actionType="approve"
                />

                <ModalAction
                    v-else-if="status === 'rejected'"
                    triggerModalClasses="block text-sm font-medium leading-5 text-red-600  hover:underline "
                    :triggerModalText="$t('delete')"
                    :cancelModalText="$t('cancel')"
                    :actionModalText="$t('delete')"
                    :title="$t('confirm')"
                    :body="`${$t('confirm_delete_text')} ${row.name}`"
                    :actionRoute="route('dashboard.volunteers.delete', row.id)"
                    actionType="delete"
                />

                <ModalAction
                    v-if="status !== 'rejected'"
                    triggerModalClasses="block text-sm font-medium leading-5 text-red-600 hover:underline "
                    :triggerModalText="$t('reject')"
                    :cancelModalText="$t('cancel')"
                    :actionModalText="$t('reject')"
                    :title="$t('confirm')"
                    :body="`${$t('confirm_reject_text')} ${row.name}`"
                    :actionRoute="route('dashboard.volunteers.reject', row.id)"
                    actionType="reject"
                />
            </template>
        </Table>
    </DashboardLayout>
</template>

<script setup>
    /** Import components. */
    import DashboardLayout from '@/Layouts/DashboardLayout.vue';
    import Pagination from '@/Components/pagination/Pagination.vue';
    import Title from '@/Components/Title.vue';
    import Table from '@/Components/tables/Table.vue';
    import ModalAction from '@/Components/modals/ModalAction.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';

    import { UserGroupIcon, UserAddIcon, UserRemoveIcon } from '@heroicons/vue/outline';
    import { UserCircleIcon } from '@heroicons/vue/solid';

    const props = defineProps({
        status: {
            type: String,
        },
        collection: {
            type: Object,
        },
    });
</script>
