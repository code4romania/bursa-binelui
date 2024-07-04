<template>
    <div
        class="grid gap-6 px-6 py-5 md:grid-cols-12"
        :class="{
            'bg-white': !alt,
            'bg-gray-100': alt,
        }"
    >
        <dt
            class="text-sm font-medium leading-6 text-gray-700 md:text-base md:col-span-5 2xl:col-span-4"
            v-text="label"
        />

        <dd class="text-sm font-medium leading-6 text-gray-700 md:text-base md:col-span-6 2xl:col-span-7">
            <slot name="value" />

            <p v-show="hasPendingChanges" class="mt-2 text-sm text-red-600" v-text="$t('field_has_pending_changes')" />
            <p v-if="hasPendingChanges" class="mt-2 text-sm text-red-600">
                {{ $t('field_pending_changes') }} {{ hasPendingChanges }}
            </p>

            <p v-show="hasErrors" class="mt-2 text-sm text-red-600" v-text="errors" />
        </dd>

        <div class="flex md:justify-end" v-if="!noEdit">
            <slot name="action" />
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    label: String,
    hasPendingChanges: {
        default: false,
    },
    alt: {
        type: Boolean,
        default: false,
    },
    errors: {
        type: String,
        default: null,
    },
    noEdit: {
        type: Boolean,
        default: false,
    },
});

const hasErrors = computed(() => {
    return props.errors !== null;
});
</script>
