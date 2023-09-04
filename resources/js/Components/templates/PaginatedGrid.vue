<template>
    <div>
        <slot />

        <template v-if="list.data?.length">
            <ul :class="[`${classes}`]" role="list">
                <template v-for="item in list.data" :key="item.id">
                    <template v-if="'project' == type">
                        <ProjectCard :project="item" :cardType="cardType" />
                    </template>

                    <template v-if="'ong' == type">
                        <OngCard :data="item" />
                    </template>

                    <template v-if="'project-summary' == cardType">
                        <ProjectSummaryCard :data="item" />
                    </template>

                    <template v-if="'project-regional' == cardType">
                        <RegionalProject :data="item" />
                    </template>

                    <template v-if="'project-championship' == cardType">
                        <ChampionshipProject :data="item" />
                    </template>
                </template>
            </ul>

            <!-- Pagination -->
            <Pagination v-if="list.links" :resource="list" />
        </template>

        <div v-else class="mt-20 text-xl font-bold text-center text-gray-700 mb-9">
            {{ $t('no_data') }}
        </div>
    </div>
</template>

<script setup>
    /** Import Components. */
    import OngCard from '@/Components/cards/OngCard.vue';
    import Pagination from '@/Components/pagination/Pagination.vue';
    import ProjectCard from '@/Components/cards/ProjectCard.vue';
    import ProjectSummaryCard from '@/Components/cards/ProjectSummaryCard.vue';
    import RegionalProject from '@/Components/cards/RegionalProject.vue';
    import ChampionshipProject from '@/Components/cards/ChampionshipProject.vue';

    /** Component props. */
    const props = defineProps({
        type: String,
        list: Object,
        classes: String,
        cardType: String,
    });
</script>
