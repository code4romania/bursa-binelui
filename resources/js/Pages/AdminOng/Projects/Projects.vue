<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('projects_title')" />

        <!-- Alert -->
        <Alert
            class="fixed right-10 top-10 w-96 z-50"
            :type="flash.error_message ? 'error' : flash.success_message ? 'success' : false"
            :message="flash.success_message || flash.error_message"
            @emptyFlash="Object.assign(flash, { success_message:'', error_message:'' });"
        />

        <!-- Dashboard template -->
        <Dashboard>
           <div class="p-9 mb-24 xl:max-w-4xl">

                <!-- Header -->
                <header class="flex items-center gap-4">
                    <div class="bg-turqoise-500 w-8 h-8 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0" name="list"/>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $t('published_projects') }}</h2>
                </header>

                <Link
                    :href="route('admin.ong.project.add', 1)"
                    class="inline-flex items-center justify-center gap-4 mt-9 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 py-2.5"
                >
                    <SvgLoader name="add" />
                    {{ $t('add_project') }}
                </Link>

                <!-- Published projects -->
                <PaginatedGrid
                    type="project"
                    :list="publishedProjects"
                    classes="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2"
                />

                <!-- Draft projects -->
                <div class="flex items-center mt-20 gap-4">
                    <div class="bg-turqoise-500 w-8 h-8 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0" name="list"/>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $t('draft_projects') }}</h2>
                </div>

                <PaginatedGrid
                    type="project"
                    :list="draftProjects"
                    classes="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2"
                />
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
    import PaginatedGrid from '@/Components/templates/PaginatedGrid.vue';
    import Alert from '@/Components/Alert.vue';

    const flash = {
        success_message:'',
        error_message:''
    }

    const publishedProjects = {
        data: [
            {
                id: '1',
                scor: 3432,
                troffes: 4,
                name: 'Asociația MediuACUM',
                title: 'Ecologizarea canalului de la marginea Tulcei',
                county: "Alba Iulia",
                activity: "Mediu",
                currentAmount: "102200",
                maxAmount: "202200",
                status:"active",
                imageUrl:'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
            },
        ],
    };

    const draftProjects = {
        data: [
            {
                id: '1',
                scor: 3432,
                troffes: 4,
                name: 'Asociația MediuACUM',
                title: 'Ecologizarea canalului de la marginea Tulcei',
                county: "Alba Iulia",
                activity: "Mediu",
                currentAmount: "102200",
                maxAmount: "202200",
                status:"active",
                imageUrl:'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
            }
        ]
    };
</script>
