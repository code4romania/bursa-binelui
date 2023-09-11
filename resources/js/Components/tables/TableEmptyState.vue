<template>
    <div class="flex items-center justify-center flex-1">
        <div class="px-12 py-16 text-center">
            <SparklesIcon class="w-12 h-12 mx-auto text-gray-200" />

            <h3 class="mt-2 text-sm text-gray-900" v-text="$t('no_data')" />
        </div>
    </div>
</template>

<script setup>
    import { SparklesIcon } from '@heroicons/vue/outline';
</script>
