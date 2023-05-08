<template>
    <PageLayout>
         <!-- Inertia page head -->
        <Head title="Dashboard" />

        <!-- Dashboard template -->
        <Dashboard>
           <div class="p-9">
                Dashboard
           </div>
        </Dashboard>
    </PageLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { Head } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Dashboard from '@/Components/templates/Dashboard.vue';
</script>
