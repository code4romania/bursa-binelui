<template>
    <div class="flex items-center gap-6 mb-12">
        <a
            :href="`https://www.facebook.com/sharer/sharer.php?u=${pageRoute}`"
            target="_blank"
            rel="noopener"
            class="transition-opacity duration-150 hover:opacity-75"
        >
            <Icon name="social/color/facebook" class="w-8 h-8" />
        </a>

        <a
            :href="`https://www.linkedin.com/sharing/share-offsite/?url=${pageRoute}`"
            target="_blank"
            rel="noopener"
            class="transition-opacity duration-150 hover:opacity-75"
        >
            <Icon name="social/color/linkedin" class="w-8 h-8" />
        </a>

        <a
            :href="`https://api.whatsapp.com/send?text=${pageRoute}`"
            target="_blank"
            rel="noopener"
            class="transition-opacity duration-150 hover:opacity-75"
        >
            <Icon name="social/color/whatsapp" class="w-8 h-8" />
        </a>

        <button
            @click="copy(url)"
            class="relative flex items-center justify-center w-8 h-8 overflow-hidden duration-150 border-2 border-blue-500 rounded-full ransition-opacity hover:opacity-75"
            :class="[copied && text === url ? 'text-white bg-blue-500' : 'text-blue-500']"
        >
            <CheckIcon v-if="copied && text === url" class="w-5 h-5" />
            <LinkIcon v-else class="w-5 h-5" />
        </button>

        <button
            @click="copy(embedCode)"
            class="relative flex items-center justify-center w-8 h-8 overflow-hidden duration-150 border-2 rounded-full border-primary-500 ransition-opacity hover:opacity-75"
            :class="[copied && text === embedCode ? 'text-white bg-primary-500' : 'text-primary-500']"
        >
            <CheckIcon v-if="copied && text === embedCode" class="w-5 h-5" />
            <CodeIcon v-else class="w-5 h-5" />
        </button>
    </div>
</template>

<script setup>
    import { computed } from 'vue';
    import { useClipboard } from '@vueuse/core';
    import Icon from '@/Components/Icon.vue';
    import { CheckIcon, LinkIcon, CodeIcon } from '@heroicons/vue/solid';

    /** Component props. */
    const props = defineProps({
        pageRoute: String,
    });

    const { text, copy, copied, isSupported } = useClipboard();

    const url = computed(() => window.location.href);

    const embedCode = computed(() => `<iframe src="${url.value}" width="100%" height="600px"></iframe>`);
</script>
