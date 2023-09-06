<template>
    <DashboardLayout>
        <Title :title="$t('projects_title')" />

        <!-- Alert -->
        <Alert
            :type="flash.error_message ? 'error' : flash.success_message ? 'success' : false"
            :message="flash.success_message || flash.error_message"
            @emptyFlash="Object.assign(flash, { success_message: '', error_message: '' })"
        />

        <Link
            v-if="route().current('admin.ong.projects')"
            :href="route('admin.ong.project.add')"
            class="inline-flex items-center justify-center gap-4 mt-9 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 py-2.5"
        >
            <PlusIcon class="w-4 h-4" />

            {{ $t('add_project') }}
        </Link>

        <Link
            v-if="route().current('admin.ong.regional.projects')"
            :href="route('admin.ong.regional.project.add')"
            class="inline-flex items-center justify-center gap-4 mt-9 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 py-2.5"
        >
            <PlusIcon class="w-4 h-4" />
            {{ $t('add_regional_project') }}
        </Link>

        <!-- Published projects -->
        <PaginatedGrid
            type="project"
            cardType="admin"
            :list="props.query"
            classes="mt-6 grid-cols-1 gap-6 md:grid-cols-2  xl:grid-cols-3 2xl:grid-cols-4"
        />
    </DashboardLayout>
</template>

<script setup>
    import { onMounted } from 'vue';

    /** Import components. */
    import DashboardLayout from '@/Layouts/DashboardLayout.vue';
    import Title from '@/Components/Title.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import PaginatedGrid from '@/Components/templates/PaginatedGrid.vue';
    import Alert from '@/Components/Alert.vue';

    import { PlusIcon } from '@heroicons/vue/solid';

    const props = defineProps({
        query: {
            type: Object,
        },
        projectStatus: {
            type: String,
        },
        flash: {
            success_message: '',
            error_message: '',
        },
    });
</script>
