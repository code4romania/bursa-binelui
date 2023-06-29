<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('donations')" />

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

                <!-- Header -->
                <header class="flex items-center gap-4">
                    <div class="bg-primary-500 w-8 h-8 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0" name="money"/>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $t('donations') }}</h2>
                </header>

                <!-- Filters -->
                <div class="my-11">
                    <div class="grid grid-cols-12 gap-6">

                        <div class="col-span-12 grid grid-cols-12 gap-6">
                            <SearchFilter
                                id="project-search"
                                class="col-span-4"
                                v-model="filter.search"
                                color="gray-700"
                                :placeholder="$t('search')"
                                @keydown.enter="filterTable"
                            />

                            <SecondaryButton
                                @click="filterTable"
                                class="py-2 col-span-2 text-center"
                            >
                                {{ $t('search') }}
                            </SecondaryButton>

                            <SecondaryButton
                                v-if="hasValues"
                                @click="emptyFilters"
                                class="py-2 col-span-2 text-center flex gap-2 items-center justify-center"
                            >
                                <SvgLoader name="close" />
                                {{ $t('empty_filters') }}
                            </SecondaryButton>

                            <div :class="['col-span-12 flex justify-end', hasValues ? 'sm:col-span-4' : 'sm:col-span-6']">
                                <SecondaryButton
                                    class="py-2 flex items-center justify-center gap-4"
                                >
                                    <SvgLoader class="shrink-0" name="download" />
                                    {{ $t('download_table') }}
                                </SecondaryButton>
                            </div>
                        </div>

                        <Select
                            class="col-span-12 sm:col-span-6 lg:col-span-4"
                            :label="$t('donation_status')"
                            v-model="filter.status"
                            :options="statuses"
                        />

                        <Select
                            class="col-span-12 sm:col-span-6 lg:col-span-4"
                            :label="$t('amount')"
                            v-model="filter.amount"
                            :options="amounts"
                        />

                        <Select
                            class="col-span-12 sm:col-span-6 lg:col-span-4"
                            :label="$t('project')"
                            v-model="filter.project"
                            :options="projects"
                        />

                        <Select
                            class="col-span-12 sm:col-span-6 lg:col-span-4"
                            :label="$t('start_date')"
                            v-model="filter.start_date"
                            :options="start_dates"
                        />

                        <Select
                            class="col-span-12 sm:col-span-6 lg:col-span-4"
                            :label="$t('start_date')"
                            v-model="filter.end_date"
                            :options="end_dates"
                        />
                    </div>
                </div>

                <Table
                    class="mb-24"
                    :columns="columns"
                    :currentPage="donations.current_page"
                    :prev="donations.prev_page_url"
                    :next="donations.next_page_url"
                    :links="donations.links"
                >
                    <tr v-for="donation in donations.data" :key="donation.id">
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ donation.id }}</td>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                            <div class="flex items-center gap-4">
                                <img v-if="donation.user.image" :src="donation.user.image" alt="avatar">
                                <SvgLoader v-else class="shrink-0" name="default_avatar" />
                                <div>
                                    <p class="text-sm text-gray-900 font-medium">{{ donation.user.name }}</p>
                                    <p class="text-sm text-gray-500">{{ donation.user.email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ donation.project }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">{{ donation.amount }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ donation.created_at }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ donation.approved_at }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ donation.uploaded_at }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ donation.withdraw_amount }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ donation.status }}</td>

                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <Modal
                                triggerModalClasses="whitespace-nowrap px-3 py-4 text-sm text-blue-500"
                                :triggerModalText="$t('edit')"
                                id="donation-edit"
                            >
                                <form class="space-y-4 w-full" @submit.prevent="editDonation">

                                    <h3 class="w-full text-gray-900 font-semibold text-lg">{{ $t('edit_donation') }}</h3>

                                    <Select
                                        class="w-full"
                                        :label="$t('project')"
                                        v-model="donation.project"
                                        :options="projects"
                                        :isDisabled="true"
                                    />

                                    <Select
                                        class="w-full"
                                        :label="$t('amount')"
                                        v-model="donation.organization"
                                        :options="projects"
                                        :isDisabled="true"
                                    />

                                    <Input
                                        class="w-full"
                                        :label="$t('amount')"
                                        color="gray-700"
                                        id="amount"
                                        type="number"
                                        v-model="donation.amount"
                                    >
                                        <p class="text-sm text-gray-700">{{ $t('two_decimals') }}</p>
                                    </Input>

                                    <Select
                                        class="w-full"
                                        :label="$t('status')"
                                        v-model="donation.status"
                                        :options="statuses"
                                    />

                                    <Textarea
                                        class="w-full"
                                        :label="$t('comment')"
                                        id="project-scope"
                                        color="gray-700"
                                        v-model="donation.comment"
                                    />

                                    <!-- Actions -->
                                    <div class="pt-6 w-full flex items-center justify-end gap-6">
                                        <SecondaryButton
                                            @click="closeModal"
                                            class="py-2.5"
                                        >
                                            {{ $t('back') }}
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
                        </td>
                    </tr>
                </Table>
           </div>
        </Dashboard>
    </PageLayout>
</template>

<script setup>
    /** Import from vue. */
    import { ref } from 'vue';

    /** Import from inertia. */
    import { Head, Link, usePage, useForm } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Dashboard from '@/Components/templates/Dashboard.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Alert from '@/Components/Alert.vue';
    import Table from '@/Components/templates/Table.vue';
    import Modal from '@/Components/modals/Modal.vue';
    import Select from '@/Components/form/Select.vue';
    import Input from '@/Components/form/Input.vue';
    import Textarea from '@/Components/form/Textarea.vue';
    import SearchFilter from '@/Components/filters/SearchFilter.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    /** Page data. */
    // const props = defineProps({
    //     donations: Array,
    //     projects: Array,
    //     flash: Object,
    //     statuses: Array,
    //     amounts: Array,
    //     start_dates: Array,
    //     end_dates: Array
    // })

    const flash = {
        success_message:'',
        error_message:''
    };

    /** Active filter state. */
    const hasValues = ref(false);

    const columns = ['#ID', ,'CATRE', 'SUMA (RON)', 'DATA CREARE', 'DATA APROBARE', 'DATA INCARCARE', 'RETRAGERE RON', 'STATUS'];

    /** Filter values. */
    const filter = ref({
        search: '',
        status: '',
        amount: '',
        project:'',
        start_date: '',
        end_date: ''
    });

    /** Filter table. */
    const filterTable = () => {
        // router.visit(route('route'), {
            // method: 'get',
            // data: filter.value,
            // preserveState: true,
            // onSuccess: (data) => {
                // if (Object.values(data.props.request).every(value => value === null)) {
                //     hasValues.value = false
                // } else {
                //     hasValues.value = true
                // }
            // }
        // })

        if (Object.values(filter).every(value => value === null)) {
            hasValues.value = false
        } else {
            hasValues.value = true
        }
    };

    /** Empty filters. */
    const emptyFilters = () => {
        // router.visit(route('route'));
    };

    /** Edit donation */
    const editDonation = (donation) => {
        const form = useForm({ ...donation });

        // form.put(route('route', donation.id), {
        //     preserveScroll: true,
        //     onSuccess: () => {},
        //     onError: () => {},
        // });
    }

    const closeModal =(() => document.getElementById('donation-edit').click());

    /**
     Remove this when retriving data from back
     * */

    /** Donations */
    const donations = {
        "current_page": 2,
        "data": [
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                id: 1,
                project: 'Fundatia pentru Voineasa',
                organization: 'Fundatia pentru Voineasa',
                amount: "300",
                created_at: '12.08.2022',
                approved_at: '12.08.2022',
                uploaded_at: '12.08.2022',
                withdraw_amount: '300',
                status: 'Incasata',
                comment: 'comment'
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

    /** Statuses */
    const statuses = ['Active', 'Inactive'];
    const projects = ['Project 1', 'Project 2', 'Project 3'];
    const amounts = ['0 - 500', '500 - 1000', '1000 - 2000'];
    const start_dates = ['2023-05-17', '2023-06-07', '2023-03-19'];
    const end_dates = ['2023-05-17', '2023-06-07', '2023-03-19'];
</script>
