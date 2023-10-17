<template>
    <div class="col-span-full grid">
        <label v-show="label" for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900" v-html="label"/>
        <div class="w-1/3 flex justify-center p-6 px-6 mt-2 border border-dashed rounded-lg border-gray-900/25">
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
        <div class="grid">
            <div v-for="(file, index) in modelValue" class="grid-cols-1">
                <img v-if="file" :src="src(file)" alt="File Preview" class="object-contain max-w-xs mt-2 aspect-square" />
                <DangerButton type="button" @click="removeImage(index)">{{ $t('remove_image') }} </DangerButton>
            </div>
        </div>
    </div>
</template>

<script setup>
    /** Import plugins. */
    import { PhotographIcon, UserCircleIcon } from '@heroicons/vue/solid';
    import DangerButton from '@/Components/buttons/DangerButton.vue';
    import {ref} from "vue";

    /** Component props. */
    const props = defineProps({
        modelValue: {
            type: String,
            required: true,
        },
        error: {
            type: String,
        },
        label:{
            type: String,
            default: null,
        },
    });

    const files = ref(props.modelValue);
    const previewImage = (e) => {
        console.log(e.target.files)
        Object.keys(e.target.files).forEach((key) => {
            files.value.push(e.target.files[key]);
        });
    };
    const removeImage = (index) => {
        files.value.splice(index, 1);
    };
    function src(file){
        if (typeof file === 'string') {
            return file;
        }
        return URL.createObjectURL(file);
    }

    /** Component emits. */
    defineEmits(['update:modelValue']);
</script>
