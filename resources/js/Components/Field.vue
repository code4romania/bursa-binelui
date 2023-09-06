<template>
    <div
        class="grid gap-6 px-4 py-6 md:grid-cols-12"
        :class="{
            'bg-white': !alt,
            'bg-gray-100': alt,
        }"
    >
        <dt class="text-sm font-medium leading-6 text-gray-700 md:text-base md:col-span-5" v-text="label" />

        <dd class="text-sm font-medium leading-6 text-gray-700 md:text-base md:col-span-6">
            <slot name="value" />

            <p v-show="hasPendingChanges" class="mt-2 text-sm text-red-600" v-text="$t('field_has_pending_changes')" />
        </dd>

        <div class="flex md:justify-end">
            <slot name="action" />
        </div>
    </div>
</template>

<script setup>
    const props = defineProps({
        label: String,
        hasPendingChanges: {
            type: Boolean,
            default: false,
        },
        alt: {
            type: Boolean,
            default: false,
        },
    });
</script>
