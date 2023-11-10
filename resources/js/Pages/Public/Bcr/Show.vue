<template>
    <PageLayout>
        <Head :title="project.name" :description="project.description" :image="project.image" />

        <!-- Header -->
        <div class="flex flex-col-reverse w-full mx-auto mt-2 mb-8 lg:flex-row lg:max-w-7xl sm:mt-0 px-9">
            <div class="flex flex-col justify-center w-full lg:w-6/12">
                <div class="flex gap-6 pt-4 mr-6 bg-white">
                    <div v-if="project.category" class="flex items-center gap-2">
                        <div class="flex items-center justify-center rounded-lg bg-primary-50 w-9 h-9">
                            <SvgLoader class="shrink-0 fill-primary-50 stroke-primary-500" name="badge" />
                        </div>
                        <p class="w-40 text-base font-semibold leading-6 text-gray-900 truncate lg:w-60">
                            {{ project.category }}
                        </p>
                    </div>
                </div>

                <h1 v-if="project.name" class="py-12 text-6xl font-extrabold text-gray-900">{{ project.name }}</h1>
            </div>

            <div class="relative items-center justify-center hidden w-full p-20 lg:w-6/12 sm:flex">
                <LargeSquarePattern class="absolute bottom-0 right-0 fill-primary-500" />

                <div class="relative flex items-center p-8 bg-white rounded shadow w-fit">
                    <img class="mx-auto" :src="project.image" alt="" />
                </div>
            </div>
        </div>

        <div class="relative flex items-center w-full mb-20 bg-white rounded shadow sm:hidden">
            <img class="mx-auto" :src="project.image" alt="" />
        </div>

        <!-- Social share -->
        <div class="container grid mx-auto mb-8 gap-y-8 gap-x-20 lg:grid-cols-5">
            <div class="lg:col-span-3">
                <h2 class="mb-8 text-3xl font-bold text-cyan-900">{{ $t('share_project') }}</h2>
                <SharePage class="mb-20" :pageRoute="route('bcr.show', project.slug)" />
            </div>

            <div class="bg-white shadow-lg drop-shadow-sm lg:col-span-2">
                <div class="px-10 pt-10 pb-8 border-b border-gray-200">
                    <h3 class="text-4xl font-bold leading-6 text-gray-900">{{ $t('project_details') }}</h3>
                </div>

                <div class="px-10 py-8 space-y-8 bg-gray-50">
                    <div class="flex justify-start gap-x-4">
                        <Icon class="w-5 h-5 mt-1 shrink-0 fill-primary-500" name="location" />
                        <div>
                            <h3 class="text-base font-semibold text-gray-600 leading-0">{{ $t('range') }}</h3>
                            <p class="mt-2 text-base font-normal text-gray-500">
                                {{ project.area }}
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-start gap-x-4">
                        <SvgLoader class="mt-1 shrink-0 fill-primary-500 stroke-primary-500" name="calendar" />
                        <div>
                            <h3 class="text-base font-semibold text-gray-600 leading-0">{{ $t('project_period') }}</h3>
                            <p class="mt-2 text-base font-normal text-gray-500">
                                {{ project.start }} - {{ project.end }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container grid mx-auto mb-8 gap-y-8 gap-x-20">
            <div class="mb-10" v-if="project.description">
                <h2 class="mb-6 text-3xl font-bold text-cyan-900">{{ $t('description') }}</h2>
                <div class="text-lg text-gray-500" v-html="project.description"></div>
            </div>
        </div>
        <div class="container space-y-10">
            <div v-if="project.external_links.length">
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex items-center justify-center w-10 h-10 p-2 text-white rounded-lg bg-primary-500">
                        <ExternalLinkIcon />
                    </div>
                    <h3 class="text-3xl font-bold text-cyan-900">{{ $t('external_links_title') }}</h3>
                </div>

                <ul class="pl-8 leading-relaxed border-l-8 border-primary-500">
                    <li
                        v-for="({ url, title, source }, index) in project.external_links"
                        :key="index"
                        class="overflow-hidden text-gray-800"
                    >
                        <a :href="url" class="inline group" target="_blank" rel="noopener">
                            <span v-text="title" class="text-blue-500 underline group-hover:no-underline" />
                        </a>

                        <span> &ndash; </span>
                        <span v-text="source" />
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-gray-100">
            <div class="container flex flex-col gap-8 py-10 mx-auto sm:flex-row">
                <div class="flex-col justify-between w-full sm:flex">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center rounded-lg bg-primary-500 w-9 h-9">
                            <SvgLoader class="fill-primary-500 shrink-0" name="brand_icon" />
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $t('gallery') }}</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div
                            class="mt-10 overflow-hidden rounded-lg group aspect-w-2 aspect-h-1"
                            v-for="(video, index) in project.embedded_videos"
                            :key="index"
                            v-html="video?.html"
                        />
                    </div>

                    <Gallery :images="project.swipe_gallery" class="mt-10" />
                </div>
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
    /** Import form vue */
    import { computed, onMounted, ref } from 'vue';

    /** Import from inertia. */
    import { Link, usePage, useForm } from '@inertiajs/vue3';
    import Head from '@/Components/Head.vue';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Icon from '@/Components/Icon.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Modal from '@/Components/modals/Modal.vue';
    import DonateModal from '@/Components/modals/DonateModal.vue';
    import VolunteerModal from '@/Components/modals/VolunteerModal.vue';
    import HowCanYouHelp from '@/Components/HowCanYouHelp.vue';
    import SharePage from '@/Components/SharePage.vue';
    import Gallery from '@/Components/Gallery.vue';

    import LargeSquarePattern from '@/Components/patterns/LargeSquarePattern.vue';
    import { ExternalLinkIcon } from '@heroicons/vue/outline';

    const props = defineProps({
        project: {
            type: Object,
            required: true,
        },
    });
    onMounted(() => {
        console.log(project);
    });
    const project = ref(props.project);

    /**
     * Copy embed code.
     */
    const copyEmbed = () => {
        /** Embed iframe. */
        const embedCode = `<iframe src="${window.location.href}" width="800px" height="600px"></iframe>`;

        /** Check if navigator object exists and copy iframe. */
        if (navigator.clipboard) {
            navigator.clipboard
                .writeText(embedCode)
                .then(() => alert('Embed code copied to clipboard!'))
                .catch(() => alert('Failed to copy embed code to clipboard!'));
        } else {
            /** Create textarea element. */
            const tempInput = document.createElement('textarea');

            /** Set textarea value as embed code. */
            tempInput.value = embedCode;

            /** Apend textarea to body. */
            document.body.appendChild(tempInput);

            /** Select textarea text. */
            tempInput.select();

            /** Copy textarea content. */
            document.execCommand('copy');

            /** Remove textarea. */
            document.body.removeChild(tempInput);
        }
    };

    /** Trigger volunteer modal from card. */
    const triggerVolunteer = () => {
        document.getElementById('volunteer-active-modal').click();
    };

    /** Trigger donate modal from card. */
    const triggerDonate = () => {
        if (false === props.project.is_period_active) {
            document.getElementById('project-donation-expired').click();
            return;
        }

        document.getElementById('donate-active-modal').click();
    };
</script>
