<template>
    <div>
        <slot />

        <template v-if="list.data.length">
            <ul :class="[`${classes}`]" role="list">
                <template v-for="item in list.data" :key="item.id">

                    <template v-if="'project' == type">
                        <ProjectCard
                            :data="item"
                            :cardType="cardType"
                        />
                    </template>

                    <template v-if="'ong' == type">
                        <OngCard :data="item"/>
                    </template>
                </template>
            </ul>

            <!-- Pagination -->
            <Pagination
                v-if="list.links && list.next_page_url"
                :currentPage="list.current_page"
                :prev="list.prev_page_url"
                :next="list.next_page_url"
                :links="list.links"
            />
        </template>

        <div
            v-else
            class="mt-20 mb-9 text-center text-gray-700 font-bold text-xl"
        >
            {{ $t('no_data') }}
        </div>
    </div>
</template>

<script setup>
    /** Import Components. */
    import ProjectCard from '@/Components/cards/ProjectCard.vue';
    import OngCard from '@/Components/cards/OngCard.vue';
    import Pagination from '@/Components/pagination/Pagination.vue';

    /** Component props. */
    defineProps({
        type: String,
        list: Object,
        classes: String,
        cardType: String
    });
</script>
