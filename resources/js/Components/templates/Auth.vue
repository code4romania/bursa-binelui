<template>
    <div class="flex min-h-full flex-1">
        <div class="flex flex-1 flex-col px-4 mt-20 sm:px-6 lg:flex-none lg:px-20 xl:px-24 mx-20">
            <div class="mx-auto w-full max-w-sm lg:w-96 mb-64">

                <div>
                    <h1 class="mb-6 text-6xl font-extrabold leading-9 tracking-tight text-cyan-900">{{ content.title }}</h1>

                    <p class="text-sm leading-6 text-gray-600">
                        {{ content.description }}
                        <a :href="content.link.href" class="text-turqoise-500 hover:text-turqoise-400">{{ content.link.text }}</a>
                    </p>

                </div>
                <slot />
            </div>
        </div>

        <div class="relative hidden w-0 flex-1 lg:block">
            <img class="absolute inset-0 h-full w-full object-cover" src="/images/auth_image.jpg" alt="Auth image" />
        </div>
    </div>
</template>

<script setup>
    /** Component props. */
    defineProps({
        content: { type: Object }
    });
</script>
