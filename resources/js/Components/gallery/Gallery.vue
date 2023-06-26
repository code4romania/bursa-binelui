<template>
    <div id="grid-list" class="grid grid-cols-4 gap-4 py-10">
        <div
            v-for="(image, index) in images"
            :key="index"
            :class="[getGridClass(index), 'relative']"

        >
            <div v-if="0===index" class="flex gap-4 h-1/4">
                <div class="flex items-center justify-center rounded-lg bg-primary-500 w-9 h-9">
                    <SvgLoader class="fill-primary-500 shrink-0" name="brand_icon" />
                </div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $t('gallery') }}</h3>
            </div>

            <video
                v-if="'video' === image.type"
                @click="openGallery=true; currentSlide=index"
                :src="image.src"
                :class="[
                    (3 < index) && (index === getLastEl(index)) ? 'pb-14' :
                    index === 0 ? 'h-3/4' : 'h-full',
                    'object-cover w-full rounded-lg'
                ]"
                controls
            ></video>

            <img
                v-if="'image' === image.type"
                @click="openGallery=true; currentSlide=index"
                :src="image.src"
                :class="[
                    (3 < index) && (index === getLastEl(index)) ? 'pb-14' :
                    index === 0 ? 'h-3/4' : 'h-full',
                    'object-cover w-full rounded-lg'
                ]"
            >

            <div
                @click="load = 4"
                :class="[
                    ((3 < index) && (index === getLastEl(index))) ? '' : 'hidden',
                    'w-full flex items-center justify-end absolute bottom-0 right-0',
                ]"
            >
                Restrange
            </div>

            <div
                @click="loadMore"
                :class="[
                    index !== getLastEl(index) ? 'hidden' : 'h-4/6',
                    'absolute top-0 left-0 w-full flex rounded-t-lg items-center justify-center text-white font-bold text-lg cursor-pointer'
                ]"
                style="background:rgba(0,0,0,.6)"
            >
                Vezi mai mult
            </div>
        </div>
    </div>

    <div v-if="openGallery" class="fixed top-0 left-0 w-full h-full z-101 bg-primary-500">
        <carousel
            class="mx-auto max-w-7xl"
            :items-to-show="1"
            :modelValue="currenSlide"
            ref="controls"
        >
            <slide
                v-for="(media, index) in gallery"
                :key="index"
            >

                <video
                    v-if="'video' === media.type"
                    :src="media.src"
                    class="w-full h-3/4"
                    controls
                ></video>

                <img
                    v-if="'image' === media.type"
                    :src="media.src"
                    class="object-cover w-full h-3/4"
                >
            </slide>

            <template #addons>
                <Navigation />
            </template>
        </carousel>

        <div class="absolute w-10 h-10 text-white cursor-pointer top-10 right-10" @click="openGallery=false">
            <SvgLoader name="big_close" class="w-full h-full fill-white"/>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

import SvgLoader from '@/Components/SvgLoader.vue';

/** Import plugins */
import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Navigation } from 'vue3-carousel';

const props = defineProps({
    gallery: Array
});



const load = ref(4);
const last = ref(3);
const openGallery = ref(false);
const currenSlide = ref(0);
const controls = ref(null);

const images = computed(() => {
    return props.gallery.slice(0, load.value);
});

const loadMore = () => {
    if (4 <= props.gallery.length - images.value.length) {
        load.value += 4;
    } else {
        load.value += props.gallery.length - images.value.length
    }
}

const getGridClass = (index) => {
    if (0 === index % 8) {
        return 'col-span-2 row-span-2';
    } else if (1 === index % 8) {
        return 'col-span-1 row-span-2';
    } else if (2 === index % 8 || 3 === index % 8) {
        return 'col-span-1 row-span-1';
    } else if (4 === index % 8) {
        return 'col-span-1 row-span-2';
    } else if (5 === index % 8 || 7 === index % 8) {
        return 'col-span-1 row-span-1';
    } else if (6 === index % 8) {
        return 'col-span-2 row-span-2';
    } else {
        return 'col-span-1 row-span-1';
    }
};

const getLastEl = (index) => {
    if ((index === images.value.length - 2) && (6 === index % 8)) {
        return last.value = index
    } else if ((index === images.value.length - 1 ) && (3 === index % 8)) {
        return last.value = index
    }
}
</script>
