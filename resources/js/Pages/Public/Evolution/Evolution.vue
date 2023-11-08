<template>
    <PageLayout>
        <Head :title="$t('evolution')" />

        <div class="mx-auto my-10 space-y-12 max-w-7xl">
            <TimeEvolution
                :donations="donations"
                :amount="amount"
                :donations_number="donations_number"
                :donations_amount="donations_amount"
                :table_data="table_data"
            />

            <ProjectsChart
                :projects="projects"
                :projects_number="projects_number"
                :counties="counties"
                :domains="domains"
                :table_data="table_data"
            />

            <AppChart :projects="projects" :projects_number="projects_number" />
        </div>
    </PageLayout>
</template>

<script setup>
    import Head from '@/Components/Head.vue';

    import PageLayout from '@/Layouts/PageLayout.vue';
    import TimeEvolution from '@/Components/charts/TimeEvolution.vue';
    import ProjectsChart from '@/Components/charts/ProjectsChart.vue';
    import AppChart from '@/Components/charts/AppChart.vue';

    const props = defineProps({
        donations: Number,
        amount: Number,
        donations_number: Array,
        donations_amount: Array,
        projects: Number,
        projects_number: Array,
        counties: Array,
        domains: Array,
        table_data: Array,
    });
</script>
