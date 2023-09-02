<template>
    <div class="flex items-center gap-6 mb-12">
        <a
            :href="`https://www.facebook.com/sharer/sharer.php?u=${pageRoute}`"
            target="_blank"
            rel="noopener"
            class="transition-opacity duration-150 hover:opacity-75"
        >
            <Icon name="facebook" class="w-8 h-8" />
        </a>

        <a
            :href="`https://www.linkedin.com/sharing/share-offsite/?url=${pageRoute}`"
            target="_blank"
            rel="noopener"
            class="transition-opacity duration-150 hover:opacity-75"
        >
            <Icon name="linkedin" class="w-8 h-8" />
        </a>

        <a
            :href="`https://api.whatsapp.com/send?text=${pageRoute}`"
            target="_blank"
            rel="noopener"
            class="transition-opacity duration-150 hover:opacity-75"
        >
            <Icon name="whatsapp" class="w-8 h-8" />
        </a>

        <button
            @click="copy(url)"
            class="relative overflow-hidden duration-150 rounded-full ransition-opacity hover:opacity-75"
        >
            <Icon v-if="copied && text === url" name="check" class="w-8 h-8 text-white bg-blue-500" />
            <Icon v-else name="link" class="w-8 h-8 text-blue-500" />
        </button>

        <button
            @click="copy(embedCode)"
            class="relative overflow-hidden duration-150 rounded-full ransition-opacity hover:opacity-75"
        >
            <Icon v-if="copied && text === embedCode" name="check" class="w-8 h-8 text-white bg-primary-500" />
            <Icon v-else name="embed" class="w-8 h-8 text-primary-500" />
        </button>
    </div>
</template>

<script setup>
    import { ref, computed } from 'vue';
    import { useClipboard } from '@vueuse/core';
    import Icon from '@/Components/Icon.vue';

    /** Component props. */
    const props = defineProps({
        pageRoute: String,
    });

    const { text, copy, copied, isSupported } = useClipboard();

    const url = computed(() => window.location.href);

    const embedCode = computed(() => `<iframe src="${url.value}" width="100%" height="600px"></iframe>`);
</script>
