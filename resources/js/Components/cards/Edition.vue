<template>
    <li
        class="flex flex-col col-span-1 bg-white divide-y divide-gray-200 rounded-lg shadow"
    >
        <div class="flex flex-col flex-1">
            <Link
                :href="route('regional.project', data.id)"
                class="relative bg-gray-200 rounded-t-lg group-hover:opacity-75 sm:h-52"
            >

                <img
                    :src="data.cover_image!=='' ?data.cover_image: '/images/no_image.jpg'"
                    alt="imagine proiect"
                    class="object-cover object-center w-full h-full rounded-t-lg sm:h-full sm:w-full"
                />
            </Link>

            <div class="px-6 pt-6">
                <p v-if="'registration' === data.status" class="pb-4 text-sm font-medium text-red-500">{{ $t('regional_registration') }}</p>
                <p v-if="'finished' === data.status" class="pb-4 text-sm font-medium text-gray-500">{{ $t('regional_finished') }}</p>
                <p v-if="'winners' === data.status" class="pb-4 text-sm font-medium text-red-500">{{ $t('regional_winners') }}</p>

                <Link
                    :href="route('regional.project', data.id)"
                    class="mt-4 text-2xl font-bold text-gray-700"
                >
                    {{ data.name }}
                </Link>
            </div>



                <Link
                    :href="route('lastedition', data.id)"
                    class="flex items-center p-6 text-sm font-semibold gap-x-2 text-primary-500"
                >
                    {{ $t('see')  }}
                    <SvgLoader name="arrow_right" class="fill-primary-500 shrink-0" />
                </Link>

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
