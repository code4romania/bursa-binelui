<template>
    <li
        class="flex flex-col col-span-1 pb-4 bg-white border-b border-primary-500"
    >
        <div class="flex flex-col flex-1 space-y-4">

            <Link
                :href="route('project', data.slug)"
                class="relative sm:h-52"
            >
                <img
                    :src="data.cover_image!=='' ?data.cover_image: 'https://images.unsplash.com/photo-1508779544523-dd1b27685be3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80'"
                    alt="imagine proiect"
                    class="object-cover object-center w-full h-full rounded-lg shadow sm:h-full sm:w-full"
                />
            </Link>

            <Link
                :href="route('project', data.slug)"
                class="text-2xl font-bold text-gray-700"
            >
                {{ data.name }}
            </Link>

            <PrimaryButton
                background="turqoise-500"
                hover="turqoise-400"
                color="white"
                class="w-full"
                @click="$emit('choosed', data)"
            >
                {{ $t('register_project') }}
            </PrimaryButton>
        </div>
    </li>
</template>

<script setup>
    /** Import from inertia. */
    import { Link } from "@inertiajs/vue3";

    /** Import components. */
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    /** Component props. */
    const props = defineProps({
        data: Object,
        cardType: String,
    });
</script>
