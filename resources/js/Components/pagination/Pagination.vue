<template>
    <nav class="flex items-center justify-between px-4 border-t border-gray-200 sm:px-0">

        <!-- Next -->
        <div class="flex flex-1 w-0 -mt-px">
            <Link
                v-if="prev"
                :href="prev"
                class="inline-flex items-center pt-4 pr-1 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700"
            >
                <ArrowLongLeftIcon class="w-5 h-5 mr-3 text-gray-400" aria-hidden="true" />
                {{ $t('prev') }}
            </Link>
        </div>

        <!-- Links -->
        <div class="hidden md:-mt-px md:flex">
            <template v-for="(link, index) in paginationLinks" :key="index" >
                <Link
                    :href="link.url"
                    :class="['inline-flex items-center border-t-2 px-4 pt-4 text-sm font-medium',
                        link.active ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'
                    ]"
                >
                    {{ link.label }}
                </Link>
            </template>
        </div>

        <!-- Prev -->
        <div class="flex justify-end flex-1 w-0 -mt-px">
            <Link
                v-if="next"
                :href="next"
                class="inline-flex items-center pt-4 pl-1 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700"
            >
                {{ $t('next') }}
                <ArrowLongRightIcon class="w-5 h-5 ml-3 text-gray-400" aria-hidden="true" />
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

        if('&laquo; Previous' === links[0].label) {
            links.shift();
        }

        if('Next &raquo;' == links[links.length - 1].label) {
            links.pop();
        }

        return links;
    })
</script>
