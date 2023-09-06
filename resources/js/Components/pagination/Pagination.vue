<template>
    <nav class="flex items-center justify-between pb-4 border-t border-gray-200">
        <!-- Next -->
        <div class="flex flex-1 w-0 -mt-px">
            <Link
                v-if="resource.links.prev"
                :href="resource.links.prev"
                class="inline-flex items-center pt-4 pr-1 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700"
            >
                <ArrowNarrowLeftIcon class="w-5 h-5 mr-3 text-gray-400" aria-hidden="true" />
                {{ $t('prev') }}
            </Link>
        </div>

        <!-- Links -->
        <div class="hidden md:-mt-px md:flex">
            <template v-for="(link, index) in paginationLinks" :key="index">
                <Link
                    :href="link.url"
                    :class="[
                        'inline-flex items-center border-t-2 px-4 pt-4 text-sm font-medium',
                        link.active
                            ? 'border-primary-500 text-primary-600'
                            : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                    ]"
                >
                    {{ link.label }}
                </Link>
            </template>
        </div>

        <!-- Prev -->
        <div class="flex justify-end flex-1 w-0 -mt-px">
            <Link
                v-if="resource.links.next"
                :href="resource.links.next"
                class="inline-flex items-center pt-4 pl-1 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700"
            >
                {{ $t('next') }}
                <ArrowNarrowRightIcon class="w-5 h-5 ml-3 text-gray-400" aria-hidden="true" />
            </Link>
        </div>
    </nav>
</template>

<script setup>
    import { computed } from 'vue';

    /** Import from inertia. */
    import { Link } from '@inertiajs/vue3';

    /** Import plugins. */
    import { ArrowNarrowLeftIcon, ArrowNarrowRightIcon } from '@heroicons/vue/solid';

    /** Component props. */
    const props = defineProps({
        resource: {
            type: Object,
            required: true,
        },
    });

    /** Forma pagination links. */
    const paginationLinks = computed(() => {
        const links = props.resource.meta.links;

        links.shift();
        links.pop();

        return links;
    });
</script>
