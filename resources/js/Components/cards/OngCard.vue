<template>
    <li class="col-span-1 flex flex-col rounded-lg bg-white shadow-md">
        <div class="flex flex-1 flex-col p-6">
            <img class="mx-auto h-32 w-32 flex-shrink-0 rounded-full" src="/images/ong.png" alt="" />

            <h3 class="mt-4 text-2xl font-bold text-gray-700 line-clamp-2">{{ data.name }}</h3>

            <div class="mt-1 flex items-center flex-wrap gap-5 text-base text-gray-800 font-medium mb-6">
                <div v-if="data.activity_domains" class="flex gap-1 items-center">
                    <SvgLoader class="shrink-0" name="activity" />
                    <p class="line-clamp-1">{{ data.activity_domains.join(', ') }}</p>
                </div>
            </div>

            <Link
                :href="route('organization', data.id)"
                class="text-center mt-auto bg-turqoise-500 hover:bg-turqoise-400 text-white focus-visible:outline-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
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
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

   /** Component props. */
   defineProps({
        data: { type: Object }
    });
</script>
