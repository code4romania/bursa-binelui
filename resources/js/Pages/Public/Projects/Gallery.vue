<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('gallery')" />

        <div class="mx-auto mt-4 mb-24 p-9 max-w-7xl">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center rounded-lg bg-primary-500 w-9 h-9">
                    <SvgLoader class="fill-primary-500 shrink-0" name="brand_icon" />
                </div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $t('gallery') }}</h1>
            </div>

            <div class="mt-10 overflow-hidden rounded-lg group aspect-w-3 aspect-h-1">
                <img
                    src="https://plus.unsplash.com/premium_photo-1683299153726-55202102e9b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                    alt=""
                    class="object-cover object-center group-hover:opacity-75"
                />
                <div
                    aria-hidden="true"
                    class="bg-gradient-to-b from-transparent to-black opacity-90 sm:absolute sm:inset-0"
                />
                <div class="flex items-center justify-center p-6 sm:absolute sm:inset-0">
                    <h3 class="flex items-center gap-4 font-semibold text-center text-white">
                        <SvgLoader name="play" />
                        {{ $t('play_video') }}
                    </h3>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-4">
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
    import Head from '@/Components/Head.vue';
    import PageLayout from '@/Layouts/PageLayout.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
</script>
