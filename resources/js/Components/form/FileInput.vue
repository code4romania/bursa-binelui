<template>
    <div>
        <label class="block text-sm font-medium leading-6 text-gray-700" v-text="label" />

        <input
            :id="id"
            type="file"
            @change="handleFileChange"
            class="block w-full focus:outline-none rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-primary-500 sm:text-sm sm:leading-6 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:px-3 file:py-[0.32rem] hover:file:bg-neutral-200"
            :accept="accept"
        />

        <img v-if="src" :src="src" alt="File Preview" class="object-contain max-w-xs mt-2 aspect-square" />
    </div>
</template>

<script setup>
    /** Import from vue. */
    import { ref, computed } from 'vue';

    /** Component props. */
    const props = defineProps({
        label: String,
        id: String,
        form: Object,
        previewable: {
            type: Boolean,
            default: false,
        },
        accept: {
            type: String,
            default: null,
        },
    });

    /** Image preview. */
    const preview = ref('');
    const isUrl = (form) => {
        if (typeof form === 'string') {
            return form.match(/\.(jpeg|jpg|gif|png)$/) != null;
        }

        return false;
    };

    const src = computed(() => {
        if (!props.previewable) {
            return null;
        }

        if (preview.value !== '') {
            return preview.value;
        }

        if (isUrl(props.form)) {
            return props.form;
        }

        return null;
    });

    /** Component emits. */
    const emit = defineEmits(['upload']);

    /** Handle file change. */
    const handleFileChange = (event) => {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = () => (preview.value = reader.result);
            reader.readAsDataURL(file);
        } else {
            // If no file is selected, clear the previewUrl value
            preview.value = '';
        }

        /** Emit file. */
        emit('upload', file);
    };
</script>
