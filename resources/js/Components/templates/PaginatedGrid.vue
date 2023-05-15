<template>
    <div>
        <slot />

        <template v-if="list.data.length">
            <ul :class="[`${classes}`]" role="list">
                <template v-for="item in list.data" :key="item.id">

                    <template v-if="'project' == type">
                        <Card :data="item" />
                    </template>

                    <template v-if="'ong' == type">
                        <OngCard :data="item"/>
                    </template>
                </template>
            </ul>

            <!-- Pagination -->
            <Pagination
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
    import Card from '@/Components/cards/OngCard.vue';
    import OngCard from '@/Components/cards/OngCard.vue';
    import Pagination from '@/Components/pagination/Pagination.vue';

    /** Component props. */
    defineProps({
        type: {
            type: String
        },
        list: {
            type: Object
        },
        classes: {
            type: String
        }
    });
</script>
