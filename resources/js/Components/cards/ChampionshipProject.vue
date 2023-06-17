<template>
    <li
        class="flex flex-col col-span-1 bg-white divide-y divide-gray-200 rounded-lg shadow"
    >
        <div class="flex flex-col flex-1">
            <Link
                :href="route('regionalproject', data.slug)"
                class="relative bg-gray-200 group-hover:opacity-75 sm:h-52"
            >

                <img
                    :src="data.cover_image!=='' ?data.cover_image: 'https://images.unsplash.com/photo-1508779544523-dd1b27685be3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80'"
                    alt="imagine proiect"
                    class="object-cover object-center w-full h-full rounded-t-lg sm:h-full sm:w-full"
                />

                <div class="absolute z-10 flex flex-wrap gap-2 bottom-3 left-3">
                    <div
                        class="inline-flex items-center px-3 py-1 text-base font-bold text-white bg-red-500 rounded-full gap-x-2"
                    >
                        <SvgLoader class="shrink-0 fill-white" name="location" />
                       4
                    </div>
                </div>
            </Link>

            <div class="p-6">
                <div class="pb-4 text-base font-medium text-gray-700">{{ data.organization.name }}</div>

                <Link
                    :href="route('regionalproject', data.slug)"
                    class="mt-4 text-2xl font-bold text-gray-700"
                >
                    {{ data.name }}
                </Link>

                <div class="flex items-center gap-5 mt-1 text-base font-medium text-gray-700">
                    <div v-if="data.county" class="flex items-center gap-1">
                        <SvgLoader class="shrink-0" name="location" />
                        {{ data.county.name }}
                    </div>

                    <div v-if="data.activity_domains" class="flex items-center gap-1">
                        <SvgLoader class="shrink-0" name="activity" />
                        <span class="w-20 truncate lg:w-40">{{ data.activity_domains.join(',') }}</span>
                    </div>
                </div>
            </div>

            <div class="w-full p-6">
                <Link
                    :href="route('regionalproject', data.slug)"
                    class="block text-center w-full mt-auto bg-turqoise-500 hover:bg-turqoise-400 text-white focus-visible:outline-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                >
                    {{ $t('see')  }}
                </Link>
            </div>
        </div>
    </li>
</template>

<script setup>
    /** Import from inertia. */
    import { Link } from "@inertiajs/vue3";

    /** Import components. */
    import SvgLoader from "@/Components/SvgLoader.vue";

    /** Component props. */
    const props = defineProps({
        data: Object,
        cardType: String,
    });
</script>
