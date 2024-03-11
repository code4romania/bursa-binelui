<template>
    <PageLayout>
        <Head
            :title="$t('evolution')"
            :description="$t('evolution_description')"
        />
        <div class="container my-8 sm:my-14 lg:my-20">

        <DonationsChart
         :title="getTitle('donation')"
         :data="donations"
         :project-categories="categoriesWithDonations"
        />

        <ProjectsChart
            :title="getTitle('projects')"
            :data="projects"
            :counties="counties"
            :filter="filter"
            :project-categories="categoriesWithDonations"
            :project-categories-list="projectCategories"

        />
        </div>

    </PageLayout>
</template>

<script setup>
import Head from '@/Components/Head.vue';
import PageLayout from '@/Layouts/PageLayout.vue';
import {onMounted} from "vue";
import {trans} from "laravel-vue-i18n";
import DonationsChart from "@/Pages/Public/Evolution/DonationsChart.vue";
import ProjectsChart from "@/Pages/Public/Evolution/ProjectsChart.vue";


    const props = defineProps({
        totalAmountDonations: Number,
        totalNumberDonations: Number,
        totalProjects: Number,
        donations: Array,
        projects: Array,
        counties: Array,
        projectCategories: Array,
        categoriesWithDonations: Array,
        filter: Object
    });
    onMounted(() => {
        console.log('props', props);
    });
    function getTitle(type) {
        if (type === 'donation')
            return `${props.totalNumberDonations} ${trans('donations')},${props.totalAmountDonations} ${trans('currency')}`;
        if (type === 'projects')
            return `${props.totalProjects} ${trans('registered_projects')}`;
    }
</script>
