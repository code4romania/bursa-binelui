<template>
    <li class="col-span-1 flex flex-col divide-y divide-gray-200 rounded-lg bg-white shadow">

        <div class="flex flex-1 flex-col">
            <div class="relative aspect-h-3 aspect-w-3 bg-gray-200 sm:aspect-none group-hover:opacity-75 sm:h-52">
                <img :src="data.imageUrl" alt="" class="h-full w-full object-cover object-center sm:h-full sm:w-full rounded-t-lg" />

                <div class="flex flex-wrap gap-2 absolute bottom-3 left-3 z-10">

                    <div class="inline-flex items-center gap-x-2 rounded-full bg-red-500 px-3 py-1 text-base font-bold text-white">
                        <SvgLoader class="shrink-0" name="troffe" />
                        {{ data.troffes }}
                    </div>

                    <div class="inline-flex items-center gap-x-1 rounded-full bg-red-500 px-3 py-1 text-base text-white">
                        <p class="font-bold">{{ $t('scor') }}</p>
                        <p class="font-bold">{{ data.scor }}</p>
                    </div>
                </div>

                <!-- Overlay -->
                <div v-if="'draft' == data.status" class="w-full h-full absolute top-0 left-0 z-100 bg-gray-500 opacity-70 rounded-t-lg"></div>
            </div>

            <div class="p-6">
                <p class="text-base font-medium text-gray-700">{{ data.name }}</p>

                <h3 class="mt-4 text-2xl font-bold text-gray-700">{{ data.title }}</h3>

                <div class="mt-1 flex items-center flex-wrap gap-5 text-base text-gray-700 font-medium">
                    <div v-if="data.county" class="flex gap-1 items-center">
                        <SvgLoader class="shrink-0" name="location" />
                        {{ data.county }}
                    </div>

                    <div v-if="data.activity" class="flex gap-1 items-center">
                        <SvgLoader class="shrink-0" name="activity" />
                        {{ data.activity }}
                    </div>
                </div>

                <div class="mt-5">

                    <div class="flex items-center justify-between mb-1 text-xl font-bold">
                        <p class="text-cyan-900">{{ data.currentAmount }} {{ $t('currency') }}</p>
                        <p class="text-turqoise-500">{{ data.maxAmount }} {{ $t('currency') }}</p>
                    </div>

                    <div class="w-full bg-gray-200 h-5 dark:bg-gray-700">
                        <div class="bg-turqoise-500 h-5" style="width: 45%"></div>
                    </div>
                </div>

                <div class="mt-4 shadow-sm border border-gray-300 rounded-md flex divide-x divide-gray-300">
                    <Link
                        :href="route('admin.ong.project.view', data.id)"
                        class="w-1/2 text-center px-3.5 py-2.5 text-sm font-semibold text-gray-900 bg-white hover:bg-gray-50"
                    >
                        {{ $t('view') }}
                    </Link>

                    <Link
                        :href="route('admin.ong.project.edit', data.id)"
                        class="w-1/2 text-center px-3.5 py-2.5 text-sm font-semibold text-gray-900 bg-white hover:bg-gray-50"
                    >
                        {{ $t('edit') }}
                    </Link>
                </div>

                <SecondaryButton class="w-full mt-4 py-2.5">
                    {{ $t('draft') }}
                </SecondaryButton>
            </div>
        </div>
    </li>
</template>

<script setup>
    /** Import from inertia. */
    import { Link } from '@inertiajs/vue3';

    /** Import components. */
    import SvgLoader from '@/Components/SvgLoader.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';

   /** Component props. */
   const props = defineProps({
        data: Object
    });
</script>
