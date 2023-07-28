<template>
    <div class="flex items-center gap-6 mb-12">
        <a :href="`https://www.facebook.com/sharer/sharer.php?u=${pageRoute}`" target="_blank" rel="noopener">
            <SvgLoader class="shrink-0" name="facebook_colored" />
        </a>

        <a :href="`https://www.linkedin.com/sharing/share-offsite/?url=${pageRoute}`" target="_blank" rel="noopener">
            <SvgLoader class="shrink-0" name="linkedin_colored" />
        </a>

        <a :href="`https://api.whatsapp.com/send?text=${pageRoute}`" data-action="share/whatsapp/share"   target="_blank" rel="noopener">
            <SvgLoader class="shrink-0" name="whatsapp_colored" />
        </a>

        <div class="relative">
            <div class="flex items-center justify-center w-8 h-8 border rounded-full border-primary-500">
                <SvgLoader @click="copyEmbed" class="shrink-0 fill-white" name="code" />
            </div>
            <span v-if="copied" class="absolute inline-flex items-center px-2 py-1 text-xs font-medium text-white rounded-full -top-2 -right-14 bg-primary-500 ring-1 ring-inset ring-primary-500">
                {{ $t('copied') }}
            </span>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue';

    /** Import components */
    import SvgLoader from '@/Components/SvgLoader.vue';

    /** Component props. */
    const props = defineProps({
        pageRoute: String
    });

    /** Component emits. */
    defineEmits(['copyCode', 'donate', 'volunteer']);

    /** Local state. */
    const copied = ref(false);

    /**
     * Copy embed code.
     */
    const copyEmbed = () => {

        /** Embed iframe. */
        const embedCode = `<iframe src="${window.location.href}" width="800px" height="600px"></iframe>`;

        /** Check if navigator object exists and copy iframe. */
        if (navigator.clipboard) {
            navigator.clipboard.writeText(embedCode)
            .then(() => alert('Embed code copied to clipboard!'))
            .catch(() => alert('Failed to copy embed code to clipboard!'));
        } else {
            /** Create textarea element. */
            const tempInput = document.createElement('textarea');

            /** Set textarea value as embed code. */
            tempInput.value = embedCode;

            /** Apend textarea to body. */
            document.body.appendChild(tempInput);

            /** Select textarea text. */
            tempInput.select();

            /** Copy textarea content. */
            document.execCommand('copy');

            /** Remove textarea. */
            document.body.removeChild(tempInput);
        }

        copied.value= true;
        setTimeout(() => { copied.value = false }, 1000)
    }
</script>
