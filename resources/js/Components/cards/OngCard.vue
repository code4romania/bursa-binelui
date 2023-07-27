<template>
    <li class="flex flex-col col-span-1 bg-white rounded-lg shadow-md">
        <div class="flex flex-col flex-1 p-6">
            <img class="flex-shrink-0 w-32 h-32 mx-auto rounded-full" :src="data.cover_image ? data.cover_image: '/images/ong.png'" alt="" />

            <Link
                :href="route('organization', data.id)"
                class="mt-4 text-2xl font-bold text-gray-700 line-clamp-2"
            >
                {{ data.name }}
            </Link>

            <div class="flex flex-wrap items-center gap-5 mt-1 mb-6 text-base font-medium text-gray-800">
                <div v-if="0 < data.activity_domains?.length" class="flex items-center gap-1">
                    <SvgLoader class="shrink-0" name="activity" />
                    <!-- <p class="line-clamp-1">{{ data.activity_domains?.map(item=>item.name).join(', ') }}</p> -->
                    <div class="flex gap-1.5 flex-wrap">
                        <p v-for="(domain, index) in data.activity_domains">{{ domain.name }}</p>
                    </div>
                </div>
            </div>


            <Link
                :href="route('organization', data.id)"
                class="text-center mt-auto bg-primary-500 hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
            >
                {{ $t('find_organization') }}
            </Link>
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
