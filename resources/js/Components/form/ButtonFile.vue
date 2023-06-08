<template>
    <div class="flex items-center gap-x-4">
        <label
            :for="id"
            :class="['relative text-gray-700 bg-white ring-inset ring-1 ring-gray-300 inline-flex items-center justify-center px-4 py-2 text-sm font-medium border border-transparent rounded-md']"
        >
            <span>{{ label }}</span>

            <input
                :id="id"
                type="file"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" @change="handleFileChange"
            />
        </label>

        <p class="text-sm font-semibold text-gray-700 truncate">{{ name }}</p>
    </div>
</template>

<script setup>
    /** Import form vue. */
    import { ref } from 'vue';

    /** Component props. */
    const props = defineProps({
        label: String,
        id: String,
    });

    /** Image preview. */
    const name = ref('');

    /** Component emits. */
    const emit = defineEmits(['upload']);

    /** Handle file change. */
    const handleFileChange = (event) => {
        const file = event.target.files[0];

        if (file) {
            name.value = file.name.slice(0, 20)
        } else {
            name.value = '';
        }

        /** Emit file. */
        emit('upload', file);
    }
</script>
