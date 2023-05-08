<template>
    <component :is="name" class="fill-current" />
</template>

<script setup>
    /** Import from vue. */
    import { defineAsyncComponent } from 'vue';

    /** Components props. */
    const props = defineProps({
        name: {
            type: String,
            required: true,
        },
    });

    /** Svg url */
    const name = defineAsyncComponent(() => import(`../../../public/images/svg/${props.name}.svg`))
</script>
