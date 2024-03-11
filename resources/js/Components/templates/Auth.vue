<template>
    <div class="grid min-h-full grid-cols-12 -mb-32">
        <div
            class="flex flex-col col-span-12 px-4 mt-20 lg:col-span-6 sm:px-6 lg:flex-none lg:px-16 xl:px-24 xl:mx-10 2xl:mx-20"
        >
            <div class="w-full mx-auto mb-64">
                <div>
                    <div class="mt-6 prose sm:prose-lg">
                        <h1 v-if="content?.title" class="tracking-tight text-primary-900" v-text="content.title" />
                        <p v-text="content?.description" />
                    </div>
                    <div class="mt-6 text-sm leading-6 text-gray-600 sm:text-base">
                        <Link
                            v-if="content?.link"
                            :href="route(content.link.href)"
                            class="text-primary-600 hover:text-primary-500 hover:underline"
                        >
                            {{ content.link.text }}
                        </Link>
                    </div>
                </div>

                <slot />
            </div>
        </div>

        <div class="sticky top-0 left-0 hidden h-screen lg:col-span-6 lg:block">
            <img
                class="absolute inset-0 object-cover w-full h-full"
                src="../../../../resources/images/login.jpg"
                alt="Auth image"
            />
        </div>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    /** Component props. */
    defineProps({
        content: { type: Object },
    });
</script>
