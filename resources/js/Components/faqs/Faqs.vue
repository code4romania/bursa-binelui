<template>
    <div>
        <div v-for="(item, index) in data" :key="index" class="w-full pb-6 border-t border-gray-200">
            <div @click="show(index)" class="flex items-center justify-between pt-6">
                <p class="text-lg font-medium text-gray-900">{{ item.title }}</p>
                <ChevrownDownIcon :id="`icon-${index}`" class="w-6 h-6 transform shrink-0 fill-white" />
            </div>

            <div :id="`content-${index}`" class="hidden mt-4 text-gray-500" v-html="item.content"></div>
        </div>
    </div>
</template>

<script setup>
    import { ChevronDownIcon } from '@heroicons/vue/solid';

    const props = defineProps({
        data: Array,
    });

    const show = (index) => {
        const content = document.getElementById(`content-${index}`);
        const icon = document.getElementById(`icon-${index}`);
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.classList.add('rotate-180');
            return;
        }
        icon.classList.remove('rotate-180');
        content.classList.add('hidden');
    };
</script>
