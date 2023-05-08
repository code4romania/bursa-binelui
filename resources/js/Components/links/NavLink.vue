<template>
    <Link
        :href="href"
        :class="[`${classes} inline-flex items-center text-base font-medium leading-5`]"
    >
        <slot />
    </Link>
</template>

<script setup>
    /** Import from vue. */
    import { computed } from 'vue';

    /** Import from inertia. */
    import { Link } from '@inertiajs/vue3';

    /** Component props. */
    const props = defineProps({
        href: {
            type: String,
            required: true,
        },
        active: {
            type: Boolean,
        },
    });

    /** Active link classes. */
    const classes = computed(() =>
        props.active ? 'text-turqoise-500 hover:text-turqoise-400' : 'text-gray-500 hover:text-turqoise-500'
    );
</script>
