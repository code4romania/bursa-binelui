<template>
    <DashboardLayout>
        <Title v-if="status === 'pending'" :title="$t('new_volunteer_requests')">
            <UserAddIcon />
        </Title>

        <Title v-else-if="status === 'rejected'" :title="$t('rejected_requests')">
            <UserRemoveIcon />
        </Title>

        <Title v-else :title="$t('my_volunteers')">
            <UserGroupIcon />
        </Title>

        <Table
            class="mb-24"
            :columns="['Nume', 'Telefon', 'Proiect', 'Data Inscriere', 'Utilizator']"
            :currentPage="volunteers.current_page"
            :prev="volunteers.prev_page_url"
            :next="volunteers.next_page_url"
            :resource="volunteers"
        >
            <tr v-for="(volunteer, index) in volunteers.data" :key="index">
                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                    <div class="flex items-center gap-4">
                        <img v-if="volunteer?.user?.image" :src="volunteer.user.image" alt="avatar" />
                        <SvgLoader v-else class="shrink-0" name="default_avatar" />

                        <div>
                            <p class="text-sm font-medium text-gray-900" v-text="volunteer.name" />
                            <p class="text-sm text-gray-500" v-text="volunteer.email" />
                        </div>
                    </div>
                </td>

                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap" v-text="volunteer.phone" />

                <td class="px-3 py-4 text-sm text-gray-900 whitespace-nowrap" v-text="volunteer.project" />

                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap" v-text="volunteer.created_at" />

                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ volunteer.has_user ? $t('yes') : $t('no') }}
                </td>

                <td class="w-0 py-4 pl-3 pr-4 text-sm text-gray-500 whitespace-nowrap sm:pr-6">
                    <div class="flex gap-4">
                        <ModalAction
                            v-if="status === 'pending'"
                            triggerModalClasses="block text-sm font-medium leading-5 text-blue-600 hover:underline "
                            :triggerModalText="$t('accept')"
                            :cancelModalText="$t('cancel')"
                            :actionModalText="$t('accept')"
                            :title="$t('confirm')"
                            :body="`${$t('confirm_accept_text')} ${volunteer.name}`"
                            :actionRoute="route('admin.ong.volunteers.approve', volunteer.id)"
                            actionType="approve"
                            :data="volunteers.data"
                        />

                        <ModalAction
                            v-else-if="status === 'rejected'"
                            triggerModalClasses="block text-sm font-medium leading-5 text-red-600  hover:underline "
                            :triggerModalText="$t('delete')"
                            :cancelModalText="$t('cancel')"
                            :actionModalText="$t('delete')"
                            :title="$t('confirm')"
                            :body="`${$t('confirm_delete_text')} ${volunteer.name}`"
                            :actionRoute="route('admin.ong.volunteers.delete', volunteer.id)"
                            actionType="delete"
                            :data="volunteer.projects"
                        />

                        <ModalAction
                            v-if="status !== 'rejected'"
                            triggerModalClasses="block text-sm font-medium leading-5 text-red-600 hover:underline "
                            :triggerModalText="$t('reject')"
                            :cancelModalText="$t('cancel')"
                            :actionModalText="$t('reject')"
                            :title="$t('confirm')"
                            :body="`${$t('confirm_reject_text')} ${volunteer.name}`"
                            :actionRoute="route('admin.ong.volunteers.reject', volunteer.id)"
                            actionType="reject"
                            :data="volunteers.data"
                        />
                    </div>
                </td>
            </tr>
        </Table>
    </DashboardLayout>
</template>

<script setup>
    /** Import components. */
    import DashboardLayout from '@/Layouts/DashboardLayout.vue';
    import Pagination from '@/Components/pagination/Pagination.vue';
    import Title from '@/Components/Title.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Table from '@/Components/Table.vue';
    import ModalAction from '@/Components/modals/ModalAction.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import { onMounted } from 'vue';

    import { UserGroupIcon, UserAddIcon, UserRemoveIcon } from '@heroicons/vue/outline';

    const props = defineProps({
        volunteers: Object,
        flash: Object,
        status: String,
    });
</script>
