<template>
    <Link
        class="px-3 py-1 font-medium rounded-full bg-primary-50 text-primary-600 hover:bg-primary-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600"
        :href="route('articles.category', category)"
    >
        {{ category.name }}
    </Link>
</template>

<script setup>
    defineProps({
        category: {
            type: Object,
            required: true,
        },
    });
</script>
