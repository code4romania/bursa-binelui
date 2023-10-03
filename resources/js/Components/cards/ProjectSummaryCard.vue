<template>
    <li class="flex flex-col col-span-1 pb-4 bg-white border-b border-primary-500">
        <div class="flex flex-col flex-1 space-y-4">
            <Link :href="route('project', data.slug)" class="relative sm:h-52">
                <img
                    :src="data.cover_image !== '' ? data.cover_image : '/images/no_image.jpg'"
                    alt="imagine proiect"
                    class="object-cover object-center w-full h-full rounded-lg shadow sm:h-full sm:w-full"
                />
            </Link>

            <Link :href="route('project', data.slug)" class="text-2xl font-bold text-gray-700">
                {{ data.name }}
            </Link>

            <PrimaryButton :label="$t('register_project')" class="w-full" @click="$emit('choosed', data)" />
        </div>
    </li>
</template>

<script setup>
    /** Import from inertia. */
    import { Link } from '@inertiajs/vue3';

    /** Import components. */
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    /** Component props. */
    const props = defineProps({
        data: Object,
        cardType: String,
    });
</script>
