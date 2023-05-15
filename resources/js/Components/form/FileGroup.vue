

<template>
    <div class="col-span-full">
        <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">{{ $t('photo_gallery') }}</label>
        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10 text-center">
            <div class="text-center">
                <PhotoIcon class="mx-auto h-12 w-12 text-gray-300" aria-hidden="true" />

                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-turqoise-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-turqoise-600 focus-within:ring-offset-2 hover:text-turqoise-500 text-center">
                        <span>{{ $t('load_image') }}</span>
                        <input
                            id="file-upload"
                            name="file-upload"
                            type="file"
                            class="sr-only"
                        />
                    </label>
                    <p class="pl-1">{{ $t('drag_image') }}</p>
                </div>

                <p class="text-xs leading-5 text-gray-600">{{ $t('file_types') }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
    /** Import plugins. */
    import { PhotoIcon, UserCircleIcon } from '@heroicons/vue/24/solid';

    /** Component props. */
    const props = defineProps({
        modelValue: {
            type: String,
            required: true,
        },
        error: {
            type: String,
        }
    });

    /** Component emits. */
    defineEmits(['update:modelValue']);
</script>
