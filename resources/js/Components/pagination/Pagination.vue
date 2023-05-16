<template>
    <nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">

        <!-- Next -->
        <div class="-mt-px flex w-0 flex-1">
            <Link
                v-if="prev"
                :href="prev"
                class="inline-flex items-center border-t-2 border-transparent pr-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700"
            >
                <ArrowLongLeftIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true" />
                {{ $t('prev') }}
            </Link>
        </div>

        <!-- Links -->
        <div class="hidden md:-mt-px md:flex">
            <template v-for="(link, index) in paginationLinks" :key="index" >
                <Link
                    :href="link.url"
                    :class="['inline-flex items-center border-t-2 px-4 pt-4 text-sm font-medium',
                        link.active ? 'border-turqoise-500 text-turqoise-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'
                    ]"
                >
                    {{ link.label }}
                </Link>
            </template>
        </div>

        <!-- Prev -->
        <div class="-mt-px flex w-0 flex-1 justify-end">
            <Link
                v-if="next"
                :href="next"
                class="inline-flex items-center border-t-2 border-transparent pl-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700"
            >
                {{ $t('next') }}
                <ArrowLongRightIcon class="ml-3 h-5 w-5 text-gray-400" aria-hidden="true" />
            </Link>
        </div>
    </nav>
</template>

<script setup>
    import { computed } from 'vue';

    /** Import from inertia. */
    import { Link } from '@inertiajs/vue3';

    /** Import plugins. */
    import { ArrowLongLeftIcon, ArrowLongRightIcon } from '@heroicons/vue/20/solid';

    /** Component props. */
    const props = defineProps({
        current_page: String,
        links: Array,
        prev: String,
        next: String
    });

    /** Forma pagination links. */
    const paginationLinks = computed(() => {
        const links = props.links;

        links.shift();
        links.pop();

        return links;
    })
</script>
