<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('gallery')" />


        <div class="p-9 mt-4 mx-auto max-w-7xl mb-24">


            <div class="flex items-center gap-4">
                <div class="bg-primary-500 w-9 h-9 rounded-lg flex items-center justify-center">
                    <SvgLoader class="fill-primary-500 shrink-0" name="brand_icon" />
                </div>
                <h1 class="text-gray-900 font-bold text-2xl">{{ $t('gallery') }}</h1>
            </div>

            <div class="group aspect-w-3 aspect-h-1 overflow-hidden rounded-lg mt-10">
                <img src="https://plus.unsplash.com/premium_photo-1683299153726-55202102e9b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="" class="object-cover object-center group-hover:opacity-75" />
                <div aria-hidden="true" class="bg-gradient-to-b from-transparent to-black opacity-90 sm:absolute sm:inset-0" />
                    <div class="flex justify-center items-center p-6 sm:absolute sm:inset-0">
                        <h3 class="font-semibold text-white text-center flex items-center gap-4">
                            <SvgLoader name="play"/>
                            {{ $t('play_video') }}
                        </h3>
                    </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-4 gap-6">
                <div v-for="(image, index) in project.gallery" :key="index" class="h-52">
                    <img
                        :src="image"
                        alt="imagine proiect"
                        class="object-cover object-center w-full h-full rounded-lg sm:h-full sm:w-full"
                    />
                </div>
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
    /** Remove this import after backend connection. */
    import project from '@/local_json/project.js';

    /** Import from inertia. */
    import { Head } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
</script>
