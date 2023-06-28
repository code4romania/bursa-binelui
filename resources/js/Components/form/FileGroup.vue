<template>
    <div class="col-span-full">
        <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">{{
                $t('photo_gallery')
            }}</label>
        <div class="flex justify-center p-6 px-6 mt-2 border border-dashed rounded-lg border-gray-900/25">
            <div class="text-center">
                <PhotoIcon class="w-12 h-12 mx-auto text-gray-300" aria-hidden="true"/>

                <div class="flex justify-center mt-4 text-sm leading-6 text-center text-gray-600">
                    <label for="file-upload"
                           class="relative font-semibold text-center bg-white rounded-md cursor-pointer text-primary-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-primary-600 focus-within:ring-offset-2 hover:text-primary-500">
                        <span>{{ $t('load_image') }}</span>
                        <input
                            id="file-upload"
                            name="file-upload"
                            type="file"
                            @change="previewImage"
                            ref="photo"
                            class="sr-only"
                        />

                    </label>
                </div>


                <p class="pl-1">{{ $t('drag_image') }}</p>

                <p class="text-xs leading-5 text-gray-600">{{ $t('file_types') }}</p>
            </div>

        </div>
        <div class="flex flex-wrap">
            <div :style="{backgroundImage:'url('+files[index]+')'}" style="background-size: contain"
                 v-for="(url,index) in modelValue"
                 class="grid content-end grid-cols-2 gap-4 mx-2 my-2 w-60 h-60 ">
                <DangerButton
                    @click="removeImage(index)"
                >{{ $t('remove_image') }}
                </DangerButton>
                <SecondaryButton
                    class="col-start-2"
                    @click="setCoverImage(index)"
                >{{ $t('set_cover_image') }}
                </SecondaryButton>
            </div>
        </div>
    </div>
</template>

<script setup>
/** Import plugins. */
import {PhotoIcon, UserCircleIcon} from '@heroicons/vue/24/solid';
import DangerButton from "@/Components/buttons/DangerButton.vue";
import PrimaryButton from "@/Components/buttons/PrimaryButton.vue";
import SecondaryButton from "@/Components/buttons/SecondaryButton.vue";

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

const files = [];
const previewImage = (e) => {
    const file = e.target.files[0];
    files.push(URL.createObjectURL(file))
    props.modelValue.push(file);
};
const removeImage = (index) => {
    files.splice(index, 1);
    props.modelValue.splice(index, 1);
};
const setCoverImage = (index) => {
//TODO set cover image
};

/** Component emits. */
defineEmits(['update:modelValue']);
</script>
