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
           <div class="p-9 mb-24 ">

                <!-- Header -->
                <header class="flex items-center gap-4">
                    <div class="bg-primary-500 w-8 h-8 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0 fill-primary-500" name="list"/>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ props.projectStatus==='draft'? $t('draft_projects'):  $t('published_projects') }}</h2>
                </header>

                <Link v-if="route().current('admin.ong.projects')"
                    :href="route('admin.ong.project.add')"
                    class="inline-flex items-center justify-center gap-4 mt-9 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 py-2.5"
                >
                    <SvgLoader name="add" />
                    {{ $t('add_project') }}
                </Link>
               <Link v-if="route().current('admin.ong.regional.projects')"
                     :href="route('admin.ong.regional.project.add')"
                     class="inline-flex items-center justify-center gap-4 mt-9 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 py-2.5"
               >
                   <SvgLoader name="add" />
                   {{ $t('add_regional_project') }}
               </Link>

                <!-- Published projects -->
                <PaginatedGrid
                    type="project"
                    cardType="admin"
                    :list="props.query"
                    classes="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
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
    import {onMounted} from "vue";

    const  props =defineProps({
        query: {
            type: Object,
        },
        projectStatus:{
            type: String,
        },
        flash : {
            success_message:'',
            error_message:''
        }
    });

</script>
