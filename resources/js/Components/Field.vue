<template>
    <div
        class="grid grid-cols-12 gap-6 px-4 py-6"
        :class="{
            'bg-white': !alt,
            'bg-gray-100': alt,
        }"
    >
        <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5" v-text="label" />

        <dd class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
            <slot name="value" />

            <p v-show="hasPendingChanges" class="mt-2 text-sm text-red-600" v-text="$t('field_has_pending_changes')" />
        </dd>

        <div class="flex justify-end col-span-1">
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
