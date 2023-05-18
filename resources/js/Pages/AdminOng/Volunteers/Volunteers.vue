<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('volunteers')" />

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
                <DropdownLinkVue class="flex items-center gap-4">
                    <div class="bg-turqoise-500 w-8 h-8 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0" name="add_white"/>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $t('new_volunteer_requests') }}</h2>
                </DropdownLinkVue>

                <Table
                    class="mb-24"
                    :columns="requests"
                    :currentPage="volunteers1.current_page"
                    :prev="volunteers1.prev_page_url"
                    :next="volunteers1.next_page_url"
                    :links="volunteers1.links"
                >
                    <tr v-for="person in volunteers1.data" :key="person.email">
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                            <div class="flex items-center gap-4">
                                <img v-if="person.user.image" :src="person.user.image" alt="avatar">
                                <SvgLoader v-else class="shrink-0" name="default_avatar" />
                                <div>
                                    <p class="text-sm text-gray-900 font-medium">{{ person.user.name }}</p>
                                    <p class="text-sm text-gray-500">{{ person.user.email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ person.user.phone ? person.user.phone : '-' }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">{{ person.proiect ? person.proiect : $t('general') }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ person.created_at }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ person.role ? person.role : $t('no') }}</td>


                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 flex items-center flex-col">
                            <ModalAction
                                triggerModalClasses="block text-sm font-medium leadin-5 text-blue-500"
                                :triggerModalText="$t('accept')"
                                :cancelModalText="$t('cancel')"
                                :actionModalText="$t('accept')"
                                :title="$t('confirm')"
                                :body="`${$t('confirm_accept_text')} ${person.user.name}`"
                                actionRoute="route('admin.client.destroy', person.user.id)"
                                :data="volunteers1.data"
                            />

                            <ModalAction
                                triggerModalClasses="block text-sm font-medium leadin-5 text-blue-500"
                                :triggerModalText="$t('reject')"
                                :cancelModalText="$t('cancel')"
                                :actionModalText="$t('reject')"
                                :title="$t('confirm')"
                                :body="`${$t('confirm_reject_text')} ${person.user.name}`"
                                actionRoute="route('admin.client.destroy', person.user.id)"
                                :data="volunteers1.data"
                            />
                        </td>
                    </tr>
                </Table>


                <!-- Header -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="bg-turqoise-500 w-8 h-8 rounded-lg flex items-center justify-center">
                            <SvgLoader class="shrink-0 fill-white" name="heart_white"/>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $t('my_volunteers') }}</h2>
                    </div>

                    <SecondaryButton
                        class="py-2.5 flex items-center justify-center gap-4"
                    >
                        <SvgLoader class="shrink-0" name="download" />
                        {{ $t('download_table') }}
                    </SecondaryButton>
                </div>

                <Table
                    class="mb-24"
                    :columns="requests"
                    :currentPage="volunteers2.current_page"
                    :prev="volunteers2.prev_page_url"
                    :next="volunteers2.next_page_url"
                    :links="volunteers2.links"
                >
                    <tr v-for="person in volunteers2.data" :key="person.email">
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                            <div class="flex items-center gap-4">
                                <img v-if="person.user.image" :src="person.user.image" alt="avatar">
                                <SvgLoader v-else class="shrink-0" name="default_avatar" />
                                <div>
                                    <p class="text-sm text-gray-900 font-medium">{{ person.user.name }}</p>
                                    <p class="text-sm text-gray-500">{{ person.user.email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ person.user.phone ? person.user.phone : '-' }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">{{ person.proiect ? person.proiect : $t('general') }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ person.created_at }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ person.role ? person.role : $t('no') }}</td>


                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 flex items-center flex-col">
                            <ModalAction
                                triggerModalClasses="block text-sm font-medium leadin-5 text-blue-500"
                                :triggerModalText="$t('elimin')"
                                :cancelModalText="$t('cancel')"
                                :actionModalText="$t('elimin')"
                                :title="$t('confirm')"
                                :body="`${$t('confirm_elimin_text')} ${person.user.name}`"
                                actionRoute="route('admin.client.destroy', person.user.id)"
                                :data="volunteers2.data"
                            />
                        </td>
                    </tr>
                </Table>

                <!-- Header -->
                <div class="flex items-center gap-4">
                    <div class="bg-turqoise-500 w-8 h-8 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0" name="block"/>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $t('rejected_requests') }}</h2>
                </div>

                <Table
                    :columns="requests"
                    :currentPage="volunteers3.current_page"
                    :prev="volunteers3.prev_page_url"
                    :next="volunteers3.next_page_url"
                    :links="volunteers3.links"
                >
                    <tr v-for="person in volunteers3.data" :key="person.email">
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                            <div class="flex items-center gap-4">
                                <img v-if="person.user.image" :src="person.user.image" alt="avatar">
                                <SvgLoader v-else class="shrink-0" name="default_avatar" />
                                <div>
                                    <p class="text-sm text-gray-900 font-medium">{{ person.user.name }}</p>
                                    <p class="text-sm text-gray-500">{{ person.user.email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ person.user.phone ? person.user.phone : '-' }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">{{ person.proiect ? person.proiect : $t('general') }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ person.created_at }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ person.role ? person.role : $t('no') }}</td>


                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 flex items-center flex-col">
                            <ModalAction
                                triggerModalClasses="block text-sm font-medium leadin-5 text-blue-500"
                                :triggerModalText="$t('delete')"
                                :cancelModalText="$t('cancel')"
                                :actionModalText="$t('delete')"
                                :title="$t('confirm')"
                                :body="`${$t('confirm_delete_text')} ${person.user.name}`"
                                actionRoute="route('admin.client.destroy', person.user.id)"
                                :data="volunteers3.data"
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
    import { Head, Link } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Dashboard from '@/Components/templates/Dashboard.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Alert from '@/Components/Alert.vue';
    import Table from '@/Components/templates/Table.vue';
    import ModalAction from '@/Components/modals/ModalAction.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';

    const flash = {
        success_message:'',
        error_message:''
    }

    const requests = ['Nume', 'Telefon', 'Proiect', 'Data Inscriere', 'Utilizator'];

    const volunteers1 = {
        "current_page": 2,
        "data": [
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                proiect: 'Fundatia pentru Voineasa',
                created_at: '12.08.2022',
                role: 'Da'
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
    const volunteers2 = {
        "current_page": 2,
        "data": [
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                proiect: 'Fundatia pentru Voineasa',
                created_at: '12.08.2022',
                role: 'Da'
            },
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                proiect: 'Fundatia pentru Voineasa',
                created_at: '12.08.2022',
                role: 'Da'
            },
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                proiect: 'Fundatia pentru Voineasa',
                created_at: '12.08.2022',
                role: 'Da'
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
    const volunteers3 = {
        "current_page": 2,
        "data": [
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                proiect: 'Fundatia pentru Voineasa',
                created_at: '12.08.2022',
                role: 'Da'
            },
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                proiect: 'Fundatia pentru Voineasa',
                created_at: '12.08.2022',
                role: 'Da'
            },
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                proiect: 'Fundatia pentru Voineasa',
                created_at: '12.08.2022',
                role: 'Da'
            },
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                proiect: 'Fundatia pentru Voineasa',
                created_at: '12.08.2022',
                role: 'Da'
            },
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                proiect: 'Fundatia pentru Voineasa',
                created_at: '12.08.2022',
                role: 'Da'
            },
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                proiect: 'Fundatia pentru Voineasa',
                created_at: '12.08.2022',
                role: 'Da'
            },
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                proiect: 'Fundatia pentru Voineasa',
                created_at: '12.08.2022',
                role: 'Da'
            },
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                proiect: 'Fundatia pentru Voineasa',
                created_at: '12.08.2022',
                role: 'Da'
            },
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                proiect: 'Fundatia pentru Voineasa',
                created_at: '12.08.2022',
                role: 'Da'
            },
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                proiect: 'Fundatia pentru Voineasa',
                created_at: '12.08.2022',
                role: 'Da'
            },
            {
                user: {
                    image: '',
                    name: 'Jane Cooper',
                    email: 'jane.cooper@example.com',
                    phone: '0755864325'
                },
                proiect: 'Fundatia pentru Voineasa',
                created_at: '12.08.2022',
                role: ''
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
