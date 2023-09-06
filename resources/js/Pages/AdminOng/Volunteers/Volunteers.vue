<template>
    <DashboardLayout>
        <Title :title="$t('volunteers')" />

        <!-- Alert -->
        <Alert
            :type="flash.error_message ? 'error' : flash.success_message ? 'success' : false"
            :message="flash.success_message || flash.error_message"
            @emptyFlash="Object.assign(flash, { success_message: '', error_message: '' })"
        />

        <DropdownLinkVue class="flex items-center gap-4">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                <SvgLoader class="shrink-0" name="add_white" v-if="status === 'pending'" />
                <SvgLoader class="shrink-0" name="block" v-else-if="status === 'rejected'" />
                <SvgLoader class="shrink-0 fill-white" name="heart_white" v-else />
            </div>
            <h2 class="text-2xl font-bold text-gray-900" v-if="status === 'pending'">
                {{ $t('new_volunteer_requests') }}
            </h2>
            <h2 class="text-2xl font-bold text-gray-900" v-else-if="status === 'rejected'">
                {{ $t('rejected_requests') }}
            </h2>
            <h2 class="text-2xl font-bold text-gray-900" v-else>{{ $t('my_volunteers') }}</h2>
        </DropdownLinkVue>

        <Table
            class="mb-24"
            :columns="requests"
            :currentPage="volunteers.current_page"
            :prev="volunteers.prev_page_url"
            :next="volunteers.next_page_url"
            :links="volunteers.links"
        >
            <tr v-for="person in volunteers.data" :key="person.email">
                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                    <div class="flex items-center gap-4">
                        <img v-if="person?.user?.image" :src="person.user.image" alt="avatar" />
                        <SvgLoader v-else class="shrink-0" name="default_avatar" />
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ person.user?.name ? person.user.name : person.first_name + ' ' + person.last_name }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ person.user?.email ? person.user.email : person.email }}
                            </p>
                        </div>
                    </div>
                </td>
                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ person.user?.phone ? person.user?.phone : person.phone }}
                </td>
                <td class="px-3 py-4 text-sm text-gray-900 whitespace-nowrap">
                    {{ person.projects ? person.projects.map((item) => item.name).join(', ') : $t('general') }}
                </td>
                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{ person.created_at }}</td>
                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ person.user_id ? $t('yes') : $t('no') }}
                </td>

                <td
                    class="relative flex flex-col items-center py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6"
                    v-if="status === 'pending'"
                >
                    <ModalAction
                        triggerModalClasses="block text-sm font-medium leadin-5 text-blue-500"
                        :triggerModalText="$t('accept')"
                        :cancelModalText="$t('cancel')"
                        :actionModalText="$t('accept')"
                        :title="$t('confirm')"
                        :body="`${$t('confirm_accept_text')} ${
                            person.user?.name ? person.user.name : person.first_name + ' ' + person.last_name
                        }`"
                        :actionRoute="route('admin.ong.volunteers.approve', person.id)"
                        :actionType="'approve'"
                        :data="volunteers.data"
                    />

                    <ModalAction
                        triggerModalClasses="block text-sm font-medium leadin-5 text-blue-500"
                        :triggerModalText="$t('reject')"
                        :cancelModalText="$t('cancel')"
                        :actionModalText="$t('reject')"
                        :title="$t('confirm')"
                        :body="`${$t('confirm_reject_text')} ${
                            person.user?.name ? person.user.name : person.first_name + ' ' + person.last_name
                        }`"
                        :actionRoute="route('admin.ong.volunteers.reject', person.id)"
                        :actionType="'reject'"
                        :data="volunteers.data"
                    />
                </td>
                <td
                    class="relative flex flex-col items-center py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6"
                    v-else-if="status === 'rejected'"
                >
                    <ModalAction
                        triggerModalClasses="block text-sm font-medium leadin-5 text-blue-500"
                        :triggerModalText="$t('delete')"
                        :cancelModalText="$t('cancel')"
                        :actionModalText="$t('delete')"
                        :title="$t('confirm')"
                        :body="`${$t('confirm_delete_text')} ${
                            person.user?.name ? person.user.name : person.first_name + ' ' + person.last_name
                        }`"
                        :actionRoute="route('admin.ong.volunteers.delete', person.id)"
                        :actionType="'deleteVolunteer'"
                        :data="person.projects"
                    />
                </td>
                <td
                    class="relative flex flex-col items-center py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6"
                    v-else
                >
                    <ModalAction
                        triggerModalClasses="block text-sm font-medium leadin-5 text-blue-500"
                        :triggerModalText="$t('reject')"
                        :cancelModalText="$t('cancel')"
                        :actionModalText="$t('reject')"
                        :title="$t('confirm')"
                        :body="`${$t('confirm_reject_text')} ${
                            person.user?.name ? person.user.name : person.first_name + ' ' + person.last_name
                        }`"
                        :actionRoute="route('admin.ong.volunteers.reject', person.id)"
                        :actionType="'reject'"
                        :data="volunteers.data"
                    />
                </td>
            </tr>
        </Table>
    </DashboardLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { Head, Link } from '@inertiajs/vue3';

    /** Import components. */
    import DashboardLayout from '@/Layouts/DashboardLayout.vue';
    import Title from '@/Components/Title.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Alert from '@/Components/Alert.vue';
    import Table from '@/Components/templates/Table.vue';
    import ModalAction from '@/Components/modals/ModalAction.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import { onMounted } from 'vue';

    const flash = {
        success_message: '',
        error_message: '',
    };

    const requests = ['Nume', 'Telefon', 'Proiect', 'Data Inscriere', 'Utilizator'];

    const props = defineProps({
        volunteers: Object,
        flash: Object,
        status: String,
    });
</script>
