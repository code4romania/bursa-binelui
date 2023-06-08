<template>
    <div class="flex items-center gap-x-4">
        <img v-if="preview" :src="preview" alt="File Preview" class="object-cover w-12 h-12 rounded-full" />
        <SvgLoader v-else name="avatar" class="w-12 h-12" />

        <label
            :for="id"
            :class="['relative inline-flex text-gray-700 bg-white ring-inset ring-1 ring-gray-300 items-center justify-center px-4 py-2 text-sm font-medium border border-transparent rounded-md']">
            <span>{{ label }}</span>
            <input
                :id="id"
                type="file"
                @change="handleFileChange"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
        </label>
    </div>
</template>

<script setup>
    /** Import from vue. */
    import { ref } from 'vue';

    /** Import Components. */
    import SvgLoader from '@/Components/SvgLoader.vue';

    /** Component props. */
    const props = defineProps({
        label: String,
        id: String,
        form: Object
    });

    /** Image preview. */
    const preview = ref('');

    /** Component emits. */
    const emit = defineEmits(['upload']);

    /** Handle file change. */
    const handleFileChange = (event) => {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = (() => preview.value = reader.result);
            reader.readAsDataURL(file);
        } else {
            // If no file is selected, clear the previewUrl value
            preview.value = '';
        }

        /** Emit file. */
        emit('upload', file);
    }
</script>
