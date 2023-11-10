<template>
    <template v-if="isMounted">
        <slot />
    </template>

    <template v-else>
        <slot name="placeholder">
            <div></div>
        </slot>
    </template>
</template>

<script setup>
    import { ref, onMounted } from 'vue';

    const isMounted = ref(false);

    onMounted(() => {
        isMounted.value = true;
    });
</script>
