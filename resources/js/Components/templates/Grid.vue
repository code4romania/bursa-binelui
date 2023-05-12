<template>
    <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2">
        <template v-for="(item, index) in list" :key="index">
            <Card :data="item" />
        </template>
    </ul>
</template>

<script setup>
    /** Import Components. */
    import Card from '@/Components/cards/Card.vue';

    /** Component props. */
   defineProps({
        list: { type: Array }
    });
</script>
