<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('evolution')" />
        <div class="mx-auto my-10 space-y-12 max-w-7xl">
            <TimeEvolution
                :donations="donations"
                :amount="amount"
                :donations_number="donations_number"
                :donations_amount="donations_amount"
            />

        </div>
    </PageLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import PageLayout from '@/Layouts/PageLayout.vue';
import TimeEvolution from '@/Components/charts/TimeEvolution.vue';
import ProjectsChart from '@/Components/charts/ProjectsChart.vue';
import AppChart from '@/Components/charts/AppChart.vue';

const props = defineProps({
    donations: Number,
    amount: Number,
    donations_number: Array,
    donations_amount: Array
});
</script>
