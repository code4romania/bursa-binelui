<template>
    <li class="flex flex-col col-span-1 bg-white rounded-lg shadow-md">
        <div class="flex flex-col flex-1">
            <Link href="#" class="relative sm:h-52">
                <img class="object-cover object-center w-full h-full rounded-t-lg sm:h-full sm:w-full" :src="data.cover_image" alt="aticle image" />
            </Link>

            <div class="p-4 space-y-6">
                <div class="flex items-center text-sm text-gray-500">
                    <span v-if="data.author">{{ data.author }} </span>
                    <span v-if="data.team">&nbsp;|&nbsp;{{ data.team }}</span>
                </div>

                <h3 class="text-2xl font-bold text-gray-700 line-clamp-2">{{ data.name }}</h3>

                <div class="text-base text-gray-500" v-html="data.content"></div>

                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">{{ data.date }}</p>
                    <Link
                        href=""
                        class="flex items-center text-sm font-semibold gap-x-2 text-primary-500"
                    >
                        {{ $t('read_article') }}
                        <SvgLoader name="arrow_right" class="fill-primary-500 shrink-0" />
                    </Link>
                </div>
            </div>
        </div>
    </li>
</template>

<script setup>
    /** Import from inertia. */
    import { Link } from '@inertiajs/vue3';

    /** Import components. */
    import SvgLoader from '@/Components/SvgLoader.vue';

   /** Component props. */
   defineProps({
        data: { type: Object }
    });

</script>
