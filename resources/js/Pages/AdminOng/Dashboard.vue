<template>
    <DashboardLayout>
        <Title :title="$t('dashbord')" :icon="ChartBarIcon" />

        <div class="border-b border-b-gray-900/10 lg:border-t lg:border-t-gray-900/5">
            <dl class="mx-auto grid max-w-7xl grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 lg:px-2 xl:px-0">
                <div class="flex items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-4 py-10 sm:px-6 lg:border-t-0 xl:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-500">{{ $t('organization') }}</dt>
                    <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">{{ data.organization.name }}</dd>
                </div>

                <div class="flex items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-4 py-10 sm:px-6 lg:border-t-0 xl:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-500">{{ $t('status') }}</dt>
                    <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">{{ $t('organization_status_'+data.organization.status) }}</dd>
                </div>

                <div class="flex items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-4 py-10 sm:px-6 lg:border-t-0 xl:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-500">{{ $t('status_document_label') }}</dt>
                    <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">{{ data.organization.has_statute ? $t('yes') : $('no') }}</dd>
                </div>
            </dl>
        </div>

        <div class="border-b border-b-gray-900/10 lg:border-t lg:border-t-gray-900/5">
            <dl class="mx-auto grid max-w-7xl grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 lg:px-2 xl:px-0">
                <div v-for="(stat, statIdx) in data.projects" :key="statIdx" class="flex items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-4 py-10 sm:px-6 lg:border-t-0 xl:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-500">{{ $t('projects.stats.'+ statIdx) }}</dt>
                    <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">{{ stat }}</dd>
                </div>
            </dl>
        </div>

        <div class="border-b border-b-gray-900/10 lg:border-t lg:border-t-gray-900/5">
            <dl class="mx-auto grid max-w-7xl grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 lg:px-2 xl:px-0">
                <div v-for="(stat, statIdx) in data.tickets" :key="statIdx" class="flex items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-4 py-10 sm:px-6 lg:border-t-0 xl:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-500">{{ $t('tickets.stats.'+ statIdx) }}</dt>
                    <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">{{ stat }}</dd>
                </div>
            </dl>
        </div>
    </DashboardLayout>
</template>

<script setup>
    /** Import components. */
    import DashboardLayout from '@/Layouts/DashboardLayout.vue';
    import Title from '@/Components/Title.vue';
    import {ChartBarIcon} from '@heroicons/vue/outline';
    import {organization} from "../../../../public/build/assets/ro-adfdc2c4.js";


    const props = defineProps({
        data: {
            type: Object,
        },
    });
</script>
