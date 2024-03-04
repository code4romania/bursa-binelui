<template>
    <div>
        <slot />

        <template v-if="list.data?.length">
            <div class="grid mb-10" :class="classes">
                <template v-for="item in list.data" :key="item.id">
                    <ProjectCard v-if="'project' === type" :project="item" :cardType="cardType" />

                    <OrganizationCard v-else-if="'ong' === type" :organization="item" />
                    <RegionalProject v-else-if="'project-regional' === type" :data="item" />
                    <ProjectSummaryCard v-else-if="'project-summary' === cardType" :data="item" />
                    <ChampionshipProject v-else-if="'project-championship' === cardType" :data="item" />
                </template>
            </div>

            <!-- Pagination -->
            <Pagination v-if="list.links && list.links.first !== list.links.last" :resource="list" />
        </template>

        <div v-else class="mt-20 text-xl font-bold text-center text-gray-700 mb-9" v-text="$t('no_data')" />
    </div>
</template>

<script setup>
    /** Import Components. */
    import OrganizationCard from '@/Components/cards/OrganizationCard.vue';
    import Pagination from '@/Components/pagination/Pagination.vue';
    import ProjectCard from '@/Components/cards/ProjectCard.vue';
    import ProjectSummaryCard from '@/Components/cards/ProjectSummaryCard.vue';
    import RegionalProject from '@/Components/cards/RegionalProject.vue';
    import ChampionshipProject from '@/Components/cards/ChampionshipProject.vue';
    import {onMounted} from "vue";

    /** Component props. */
    const props = defineProps({
        type: String,
        list: Object,
        classes: String,
        cardType: String,
    });
</script>
