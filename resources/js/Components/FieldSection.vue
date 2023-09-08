<template>
    <section>
        <h2 v-if="title" class="mb-4 text-lg font-bold text-gray-900" v-text="title" />
        <dl class="border border-gray-100 divide-y divide-gray-100">
            <slot />
        </dl>
    </section>
</template>

<script setup>
    defineProps({
        title: {
            type: String,
            default: null,
        },
    });
</script>
