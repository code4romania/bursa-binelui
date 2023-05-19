<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('closed_tickets')" />

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
                <div class="flex flex-wrap mb-10">
                    <Link
                        :href="route('admin.ong.tickets.open')"
                        :class="['py-2.5 px-3.5 text-sm font-semibold', route().current('admin.ong.tickets.open') ? 'bg-turqoise-500 text-white' : 'bg-turqoise-50 text-turqoise-500']"
                    >
                        {{ $t('open_tickets') }}
                    </Link>

                    <Link
                        :href="route('admin.ong.tickets.closed')"
                        :class="['py-2.5 px-3.5 text-sm font-semibold', route().current('admin.ong.tickets.closed') ? 'bg-turqoise-500 text-white' : 'bg-turqoise-50 text-turqoise-500']"
                    >
                        {{ $t('closed_tickets') }}
                    </Link>
                </div>

                <header class="flex items-center gap-4">
                    <div class="bg-turqoise-500 w-8 h-8 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0 fill-turqoise-500" name="checked"/>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $t('closed_tickets') }}</h1>
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
    import Alert from '@/Components/Alert.vue';
    import Table from '@/Components/templates/Table.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';

    const flash = {
        success_message:'',
        error_message:''
    }

    const columns = ['Subiect', 'Data'];

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
