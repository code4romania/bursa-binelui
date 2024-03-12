<template>
    <DashboardLayout>
        <Title :title="$t('projects_title')" />

        <div class="grid grid-cols-4 bg-gray-50 rounded-lg shadow py-8 px-20" v-for="item in edition.gales">
            <div class="col-span-3">
                <h3 class="text-2xl font-bold text-gray-800 divide-x divide-gray-200" v-text="item.title" />
                <div class="mt-2 flex">
                    <Icon class="w-5 h-5 shrink-0 text-primary-900" name="location" />
                    <p v-text="$t('county_available_for_participation')" class="accent-gray-500 text-md" />
                    <p v-text="item.counties" />
                </div>
            </div>
            <div
                class="grid-cols-2 justify-center content-center items-center border-l-2 px-20"
                v-if="item.registration_is_open"
            >
                <h3 v-text="$t('registration_active')" class="accent-gray-500 text-md mb-4" />
                <Link
                    :href="route('dashboard.projects.regional.create', { gala: item.id })"
                    class="flex items-center justify-center gap-2 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:opacity-50 disabled:cursor-default bg-primary-500 hover:bg-primary-400 text-white focus-visible:outline-primary-500"
                >
                    <span v-text="$t('add_project')" />
                    <ChevronRightIcon class="w-4 h-4 shrink-0" />
                </Link>
            </div>
            <div class="grid-cols-2 justify-center content-center items-center border-l-2 px-20" v-else>
                <h3 v-text="$t('registration_inactive')" class="accent-gray-500 text-md mb-4" />
            </div>
        </div>

        <PaginatedGrid
            type="project-regional"
            cardType="admin"
            :list="props.query"
            classes="mt-6 grid-cols-1 gap-6 md:grid-cols-2  xl:grid-cols-3 2xl:grid-cols-4"
        />
    </DashboardLayout>
</template>

<script setup>
/** Import components. */
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Title from '@/Components/Title.vue';
import PaginatedGrid from '@/Components/templates/PaginatedGrid.vue';
import Icon from '@/Components/Icon.vue';
import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

import { ChevronRightIcon } from '@heroicons/vue/outline';
import { onMounted } from 'vue';
import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
const props = defineProps({
    query: {
        type: Object,
    },
    flash: {
        success_message: '',
        error_message: '',
    },
    edition: {
        type: Object,
    },
});

onMounted(() => {
    console.log(props.edition);
});
</script>
