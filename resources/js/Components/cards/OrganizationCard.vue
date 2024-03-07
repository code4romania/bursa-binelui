<template>
    <article class="flex flex-col overflow-hidden bg-white divide-y divide-gray-200 rounded-lg drop-shadow-lg">
        <Link
            :href="route('organizations.show', organization)"
            class="relative block w-full px-12 py-6 overflow-hidden group"
        >
            <div class="aspect-w-3 aspect-h-2">
                <img
                    :src="organization.logo"
                    class="object-contain object-center w-full transition-opacity duration-150 group-hover:opacity-75"
                    alt=""
                />
            </div>
        </Link>

        <div class="p-6 text-left">
            <h1 class="text-xl font-extrabold text-gray-700 sm:text-2xl md:text-xl 2xl:text-2xl">
                <Link :href="route('organizations.show', organization)">
                    {{ organization.name }}
                </Link>
            </h1>

            <div
                v-if="organization.activity_domains"
                class="flex items-center gap-1 mt-1 text-sm font-medium text-gray-800"
            >
                <BookmarkIcon class="w-5 h-5 shrink-0" />
                <span class="text-gray-700 truncate" v-text="organization.activity_domains" />
            </div>

            <Link
                :href="route('organizations.show', organization)"
                class="text-center w-full block mt-6 bg-primary-500 hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
            >
                {{ $t('find_organization') }}
            </Link>
        </div>
    </article>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import { BookmarkIcon } from '@heroicons/vue/solid';

    /** Component props. */
    defineProps({
        organization: {
            type: Object,
            required: true,
        },
    });
</script>
