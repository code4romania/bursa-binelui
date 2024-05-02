<template>
    <div :id="galleryID" class="grid gap-2 mt-10 sm:grid-cols-2 lg:grid-cols-4 my-gallery">
        <a
            v-for="(image, key) in images"
            :key="key"
            :href="image.src"
            :data-pswp-width="image.width"
            :data-pswp-height="image.height"
            target="_blank"
            rel="noreferrer"
        >
            <img :src="image.thumbnail" alt="" />
        </a>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import PhotoSwipeLightbox from 'photoswipe/lightbox';
import 'photoswipe/style.css';

const props = defineProps({
    galleryID: {
        type: String,
        required: false,
        default: 'test',
    },
    images: {
        type: Array,
        required: true,
    },
});

const lightbox = ref(null);

onMounted(() => {
    if (lightbox.value !== null) {
        return;
    }

    lightbox.value = new PhotoSwipeLightbox({
        gallery: '#' + props.galleryID,
        children: 'a',
        pswpModule: () => import('photoswipe'),
    });

    lightbox.value.init();
});

onUnmounted(() => {
    if (!lightbox.value) {
        return;
    }

    lightbox.value.destroy();
    lightbox.value = null;
});
</script>
