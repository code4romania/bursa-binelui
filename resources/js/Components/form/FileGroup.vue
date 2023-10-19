<template>
    <div class="grid gap-8">
        <div>
            <label
                v-show="label"
                for="cover-photo"
                class="block text-sm font-medium leading-6 text-gray-900"
                v-text="label"
            />

            <div class="flex justify-center p-6 px-6 mt-2 border border-dashed rounded-lg border-gray-900/25">
                <div class="text-center">
                    <PhotographIcon class="w-12 h-12 mx-auto text-gray-300" aria-hidden="true" />

                    <div class="flex justify-center mt-4 text-sm leading-6 text-center text-gray-600">
                        <label
                            for="file-upload"
                            class="relative font-semibold text-center bg-white rounded-md cursor-pointer text-primary-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-primary-600 focus-within:ring-offset-2 hover:text-primary-500"
                        >
                            <span>{{ $t('load_image') }}</span>
                            <input
                                id="file-upload"
                                name="file-upload"
                                type="file"
                                @change="previewImage"
                                ref="photo"
                                multiple
                                class="sr-only"
                            />
                        </label>
                    </div>

                    <p class="pl-1">{{ $t('drag_image') }}</p>

                    <p class="text-xs leading-5 text-gray-600">{{ $t('file_types') }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <div v-for="(file, index) in files" :key="index" class="relative aspect-1">
                <img v-if="file" :src="src(file)" alt="" class="object-cover" />
                <DangerButton
                    type="button"
                    @click="removeImage(index)"
                    :title="$t('remove_image')"
                    class="absolute top-0 right-0 rounded-tr-none"
                >
                    <TrashIcon class="w-4 h-4" />
                </DangerButton>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'FileGroup',
    inheritAttrs: false,
    customOptions: {}
}
</script>
<script setup>


    /** Import plugins. */
    import { PhotographIcon, UserCircleIcon } from '@heroicons/vue/solid';
    import DangerButton from '@/Components/buttons/DangerButton.vue';
    import { ref } from 'vue';
    import { TrashIcon } from '@heroicons/vue/solid';

    /** Component props. */
    const props = defineProps({
        modelValue: {
            type: String,
            required: true,
        },
        error: {
            type: String,
        },
        label: {
            type: String,
            default: null,
        },
    });

    const files = ref(props.modelValue);
    const previewImage = (e) => {
        Object.keys(e.target.files).forEach((key) => {
            files.value.push(e.target.files[key]);
        });

    };
    const removeImage = (index) => {
        files.value.splice(index, 1);
    };
    function src(file) {
        if (typeof file === 'string') {
            return file;
        }
        if (typeof file === 'object' && file instanceof File) {
            return URL.createObjectURL(file);
        }
        if (typeof file === 'object' && file.url!==undefined) {
            return file.url
        }
        return URL.createObjectURL(file);
    }

    /** Component emits. */
    defineEmits(['update:modelValue']);
</script>
