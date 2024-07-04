<template>
    <li class="flex flex-col col-span-1 bg-white divide-y divide-gray-200 rounded-lg shadow">
        <div class="flex flex-col flex-1">
            <Link :href="route('regional.project', data)" class="relative bg-gray-200 group-hover:opacity-75 sm:h-52">
                <img
                    :src="data.image !== '' ? data.image : '/images/no_image.jpg'"
                    alt="imagine proiect"
                    class="object-cover object-center w-full h-full rounded-t-lg sm:h-full sm:w-full"
                />

                <div class="absolute z-10 flex flex-wrap gap-2 bottom-3 left-3">
                    <div
                        class="inline-flex items-center px-3 py-1 text-base font-bold text-white bg-red-500 rounded-full gap-x-2"
                    >
                        <LocationMarkerIcon class="w-5 h-5 shrink-0" />
                        {{ data.counties_count }}
                    </div>
                </div>
            </Link>
            <div class="flex flex-col items-start justify-end gap-2 p-3">
                <ProjectTag v-if="data.is_draft" :label="$t('project_draft')" />
                <ProjectTag v-else-if="!data.is_draft" :label="$t('projects.status.published')" />
            </div>
            <div class="p-6 pt-2">
                <div class="pb-4 text-base font-medium text-gray-700">{{ data.organization.name }}</div>

                <Link :href="route('regional.project', data.slug)" class="mt-4 text-2xl font-bold text-gray-700">
                    {{ data.name }}
                </Link>

                <div class="flex items-center gap-5 mt-1 text-base font-medium text-gray-700">
                    <div v-if="data.counties" class="flex items-center gap-1">
                        <LocationMarkerIcon class="w-5 h-5 shrink-0 fill-primary-500" />
                        {{ data.counties }}
                    </div>

                    <div v-if="data.categories" class="flex items-center gap-1">
                        <BookmarkIcon class="w-5 h-5 shrink-0 fill-gray-500" />
                        <span class="w-full">{{ data.categories }}</span>
                    </div>
                </div>
            </div>
            <div class="w-full p-6 grid grid-cols-2 gap-2">
                <Link
                    :href="route('regional.project', data.slug)"
                    class="block text-center w-full col-span-full mt-auto bg-primary-500 hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                >
                    {{ $t('see') }}
                </Link>
                <template v-if="data.is_draft">
                    <Link
                        :href="route('dashboard.projects.gala.edit', data.slug)"
                        v-text="$t('edit')"
                        class="block text-center w-full mt-auto bg-primary-500 hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                    />
                    <PrimaryButton :label="$t('publish')" class="w-full mt-4" @click="publishProject(data)" />
                </template>
            </div>
        </div>
    </li>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';

/** Import components. */
import { LocationMarkerIcon, BookmarkIcon } from '@heroicons/vue/solid';
import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
import ProjectTag from '@/Components/projects/Tag.vue';
import route from '@/Helpers/useRoute';

/** Component props. */
const props = defineProps({
    data: Object,
    cardType: String,
});
const form = useForm({
    project: null,
    status: 'published',
});

const publishProject = (project) => {
    form.project = project;
    form.post(route('dashboard.projects.gala.status', project.slug), {
        onSuccess: () => {
            form.project = null;
            form.status = 'published';
        },
        onError: () => {
            form.project = null;
            form.status = 'published';
        },
        onFinish: () => {
            form.project = null;
            form.status = 'published';
        },
    });
};
</script>
