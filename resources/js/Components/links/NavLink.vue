<template>
    <Link
        :href="href"
        class="inline-flex font-medium leading-5"
        :class="{
            'text-primary-600 hover:text-primary-500': active,
            'text-gray-500 hover:text-primary-600': !active,
        }"
    >
        <slot />
    </Link>
</template>

<script setup>
    defineProps({
        href: {
            type: String,
            required: true,
        },
        active: {
            type: Boolean,
            default: false,
        },
    });
</script>
