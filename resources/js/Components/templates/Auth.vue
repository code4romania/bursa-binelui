<template>
    <div class="grid min-h-full grid-cols-12">
        <div class="flex flex-col col-span-12 px-4 mt-20 lg:col-span-6 sm:px-6 lg:flex-none lg:px-16 xl:px-24 xl:mx-10 2xl:mx-20">
            <div class="w-full mx-auto mb-64">

                <div>
                    <h1 v-if="content.hasOwnProperty('title')" class="text-6xl font-extrabold tracking-tight text-cyan-900">{{ content.title }}</h1>

                    <p class="mt-6 text-sm leading-6 text-gray-600">
                        <span v-if="content.hasOwnProperty('description')">{{ content.description }}&nbsp;</span>
                        <Link v-if="content.hasOwnProperty('link')" :href="route(content.link.href)" class="text-primary-500 hover:text-primary-400">{{ content.link.text }}</Link>
                    </p>

                </div>
                <slot />
            </div>
        </div>

        <div class="sticky top-0 left-0 hidden h-screen lg:col-span-6 lg:block">
            <img class="absolute inset-0 object-cover w-full h-full" src="/images/auth_image.jpg" alt="Auth image" />
        </div>
    </div>
</template>

<script setup>
    import {Link} from '@inertiajs/vue3';
    /** Component props. */
    defineProps({
        content: { type: Object }
    });
</script>
