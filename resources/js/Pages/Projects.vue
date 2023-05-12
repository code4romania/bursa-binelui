<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head title="Projects" />

        <!-- Dashboard template -->
        <Dashboard>
           <div class="p-9 xl:max-w-4xl">
                <div class="flex items-center gap-4">
                    <SvgLoader name="list"/>
                    <h2 class="text-2xl font-bold text-gray-900">Proiecte Active</h2>
                </div>

                <SecondaryButton
                    class="flex items-center justify-center gap-4 mt-9"
                >
                    <component :is="PlusIcon" :class="['h-6 w-6 shrink-0']" aria-hidden="true" />
                    Adaugă un proiect
                </SecondaryButton>

                <Grid class="mt-6" :list="activeProjects" />

                <div class="flex items-center mt-20 gap-4">
                    <SvgLoader name="list"/>
                    <h2 class="text-2xl font-bold text-gray-900">Proiecte Draft</h2>
                </div>

                <Grid class="mt-6" :list="draftProjects" />
           </div>
        </Dashboard>
    </PageLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { Head } from '@inertiajs/vue3';

    /** Import plugins. */
    import { PlusIcon } from '@heroicons/vue/24/outline';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Dashboard from '@/Components/templates/Dashboard.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Grid from '@/Components/templates/Grid.vue';

    /** Grid list */
    const activeProjects = [
        {
            name: 'Asociația MediuACUM',
            title: 'Ecologizarea canalului de la marginea Tulcei',
            county: "Alba Iulia",
            activity: "Mediu",
            currentAmount: "102200",
            maxAmount: "202200",
            status:"active",
            imageUrl:'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
        },

        {
            name: 'Asociația MediuACUM',
            title: 'Ecologizarea canalului de la marginea Tulcei',
            county: "Alba Iulia",
            activity: "Mediu",
            currentAmount: "102200",
            maxAmount: "202200",
            status:"draft",
            imageUrl:'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
        },

        {
            name: 'Asociația MediuACUM',
            title: 'Ecologizarea canalului de la marginea Tulcei',
            county: "Alba Iulia",
            activity: "Mediu",
            currentAmount: "102200",
            maxAmount: "202200",
            status:"active",
            imageUrl:'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
        },
    ];

    /** Grid list */
    const draftProjects = [
        {
            name: 'Asociația MediuACUM',
            title: 'Ecologizarea canalului de la marginea Tulcei',
            county: "Alba Iulia",
            activity: "Mediu",
            currentAmount: "102200",
            maxAmount: "202200",
            status:"active",
            imageUrl:'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
        }
    ];
</script>
