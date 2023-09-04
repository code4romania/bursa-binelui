<template>
    <div>
        <PrimaryButton
            id="championship-modal"
            background="primary-500"
            hover="primary-400"
            color="white"
            class="w-full"
            @click="show = !show"
        >
            {{ $t('register_project') }}
        </PrimaryButton>

        <div v-if="show" class="fixed top-0 left-0 right-0 w-full h-full bg-gray-500 bg-opacity-75 z-101">
            <div class="relative w-full mx-auto mt-16 bg-white lg:mt-24 lg:flex-row lg:max-w-7xl py-9">
                <h3 class="text-2xl font-bold text-gray-900 px-9">{{ $t('choose_project') }}</h3>
                <div class="absolute top-0 right-0 hidden pr-4 pt-9 sm:block">
                    <button
                        type="button"
                        class="text-gray-900 bg-white rounded-md hover:text-gray-500"
                        @click="show = false"
                    >
                        <span class="sr-only">Close</span>
                        <XIcon class="w-8 h-8" aria-hidden="true" />
                    </button>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>

<script setup>
    /** Import form vue. */
    import { ref } from 'vue';

    /** Import plugins */
    import { XIcon } from '@heroicons/vue/outline';

    /** Import components. */
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    const show = ref(false);
</script>
