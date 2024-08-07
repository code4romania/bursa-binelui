<template>
    <PageLayout>
        <Head :title="project.name" :description="project.description" :image="project.image" />

        <!-- Header -->
        <div class="flex flex-col-reverse w-full mx-auto mt-2 mb-8 lg:flex-row lg:max-w-7xl sm:mt-0 px-9">
            <div class="flex flex-col justify-center w-full lg:w-6/12">
                <div class="flex gap-6 pt-4 mr-6 bg-white">
                    <div class="flex items-center gap-2">
                        <div
                            :class="[
                                'w-8 h-8 rounded-lg flex items-center justify-center',
                                project.is_period_active ? 'bg-red-500' : 'bg-primary-500',
                            ]"
                        >
                            <LightningBoltIcon class="w-6 h-6 shrink-0 stroke-white" />
                        </div>
                        <p class="text-base font-semibold leading-6 text-gray-900">
                            {{ $t('projects.status.' + project.status) }}
                        </p>
                    </div>

                    <div v-if="project.categories" class="flex items-center gap-2">
                        <div class="flex items-center justify-center w-8 h-8 p-1 rounded-lg bg-primary-50">
                            <BookmarkIcon class="stroke-primary-400 shrink-0" />
                        </div>
                        <p class="w-40 text-base font-semibold leading-6 text-gray-900 truncate lg:w-60">
                            {{ project.categories }}
                        </p>
                    </div>
                </div>

                <h1 v-if="project.name" class="py-12 text-6xl font-extrabold text-gray-900">{{ project.name }}</h1>
                <h2 v-if="project.organization.name" class="mb-8 text-3xl font-bold text-primary-900">
                    {{ project.organization.name }}
                </h2>

                <div class="flex flex-col w-full gap-4 sm:flex-row">
                    <!-- Donate modal -->
                    <DonateModal
                        v-if="project.is_active && !project.is_starting_soon"
                        triggerModalClasses="bg-primary-500 w-full sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        :triggerModalText="$t('donate_btn')"
                        :data="project"
                    />
                    <!-- Volunteer modal -->
                    <VolunteerModal
                        v-if="project.accepting_volunteers"
                        triggerModalClasses="rounded-md w-full sm:w-auto bg-white text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 px-3.5 py-2.5"
                        :triggerModalText="$t('become_volunter')"
                        :data="project"
                        :postUrl="route('projects.volunteer', project.slug)"
                    />
                </div>
            </div>

            <div class="relative items-center justify-center hidden w-full p-20 lg:w-6/12 sm:flex">
                <LargeSquarePattern class="absolute bottom-0 right-0 fill-primary-500" />

                <div class="relative flex items-center p-8 bg-white rounded shadow w-fit">
                    <img class="mx-auto" :src="project.image" alt="" />
                </div>
            </div>
        </div>

        <!-- Target amount -->
        <div class="py-10 mb-20 bg-gray-100">
            <div class="container">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-8 h-8 p-1 rounded-lg bg-primary-500">
                        <ChartBarIcon class="w-6 h-6 stroke-white shrink-0" />
                    </div>

                    <h3 class="text-2xl font-bold text-gray-900">{{ $t('target_amount') }}</h3>
                </div>

                <div class="mt-8">
                    <div class="flex items-center justify-between mb-1 text-xl font-bold">
                        <p class="text-primary-900">{{ project.donations.total }}</p>
                        <p class="text-primary-500">{{ project.donations.target }}</p>
                    </div>

                    <div class="w-full h-6 bg-gray-300">
                        <div
                            :class="[
                                `h-6`,
                                project.donations.total === project.donations.target
                                    ? 'bg-primary-500'
                                    : 'bg-primary-900',
                            ]"
                            :style="`width: ${project.donations.percentage}%`"
                        ></div>
                    </div>

                    <p class="mt-1 text-xl font-bold text-primary-900">
                        {{ project.donations.count }} {{ $t('donations') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="relative flex items-center w-full mb-20 bg-white rounded shadow sm:hidden">
            <img class="mx-auto" :src="project.image" alt="" />
        </div>

        <!-- Social share -->
        <div class="container grid items-start mx-auto mb-8 gap-y-8 gap-x-20 lg:grid-cols-5">
            <div class="lg:col-span-3">
                <h2 class="mb-8 text-3xl font-bold text-primary-900">{{ $t('share_project') }}</h2>

                <SharePage class="mb-20" :pageRoute="route('projects.show', project.slug)" />

                <div class="mb-10" v-if="project.description">
                    <h2 class="mb-6 text-3xl font-bold text-primary-900">{{ $t('description') }}</h2>
                    <div class="text-lg text-gray-500" v-text="project.description" />
                </div>
            </div>

            <div class="bg-white shadow-lg drop-shadow-sm lg:col-span-2">
                <div class="px-10 pt-10 pb-8 border-b border-gray-200">
                    <h3 class="text-4xl font-bold leading-6 text-gray-900">{{ $t('project_details') }}</h3>
                </div>

                <div class="px-10 py-8 space-y-8 bg-gray-50">
                    <div class="flex justify-start gap-x-4">
                        <LocationMarkerIcon class="w-5 h-5 shrink-0 fill-primary-500" />
                        <div>
                            <h3 class="text-base font-semibold text-gray-600 leading-0">{{ $t('range') }}</h3>
                            <p class="mt-2 text-base font-normal text-gray-500" v-if="!project.is_national">
                                {{ project.counties }}
                            </p>
                            <p class="mt-2 text-base font-normal text-gray-500" v-if="project.is_national">
                                {{ $t('is_national') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-start gap-x-4">
                        <CalendarIcon class="w-5 h-5 shrink-0 fill-primary-500" />
                        <div>
                            <h3 class="text-base font-semibold text-gray-600 leading-0">{{ $t('period') }}</h3>
                            <p class="mt-2 text-base font-normal text-gray-500">
                                {{ project.start }} - {{ project.end }}
                            </p>
                            <p
                                v-if="5 >= project.end && 0 < project.end"
                                class="mt-1 text-base font-semibold text-primary-500"
                            >
                                {{ $t('project_ends') }} {{ project.end }} {{ $t('days') }}!
                            </p>
                        </div>
                    </div>

                    <!-- Donate modal -->
                    <DonateModal
                        v-if="project.is_active && !project.is_starting_soon"
                        triggerModalClasses="bg-primary-500 w-full hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        :triggerModalText="$t('donate_btn')"
                        :data="project"
                    />
                </div>
            </div>
        </div>

        <!-- Project info -->
        <div class="container space-y-10">
            <div v-if="project.scope">
                <h2 class="mb-6 text-3xl font-bold text-primary-900">{{ $t('project_scope_label') }}</h2>
                <div class="text-lg text-gray-500" v-text="project.scope" />
            </div>

            <div v-if="project.beneficiaries">
                <h2 class="mb-6 text-3xl font-bold text-primary-900">{{ $t('project_beneficiary_label') }}</h2>
                <div class="text-lg text-gray-500" v-text="project.beneficiaries" />
            </div>

            <div v-if="project.reason_to_donate">
                <h2 class="mb-6 text-3xl font-bold text-primary-900">{{ $t('why_to_donate') }}</h2>
                <div class="text-lg text-gray-500" v-text="project.reason_to_donate" />
            </div>

            <div v-if="project.external_links.length">
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex items-center justify-center w-8 h-8 p-1 text-white rounded-lg bg-primary-500">
                        <ExternalLinkIcon />
                    </div>
                    <h3 class="text-3xl font-bold text-primary-900">{{ $t('external_links_title') }}</h3>
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

        <HowCanYouHelp
            class="mb-20"
            :pageRoute="route('projects.show', project.slug)"
            :acceptsVolunteers="project.accepting_volunteers"
        />

        <!-- Gallery -->
        <div class="mb-24 bg-gray-100">
            <div class="container flex flex-col gap-8 py-10 mx-auto sm:flex-row">
                <div class="flex-col justify-between w-full sm:flex">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-8 h-8 p-1 rounded-lg bg-primary-500">
                            <ChartBarIcon class="stroke-white shrink-0" />
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

        <div class="container flex flex-col-reverse items-center py-10 sm:flex-row sm:pr-20">
            <div class="w-10/12 sm:w-3/12">
                <img
                    class="relative z-50 flex-shrink-0 w-full mx-auto shadow-lg -mt-36 sm:mt-0 sm:-mr-36 rounded-xl"
                    :src="project.organization.logo"
                    alt=""
                />
            </div>

            <div
                class="relative z-30 w-11/12 h-full p-8 py-20 overflow-hidden bg-primary-500 rounded-xl pb-60 sm:pb-10 sm:pl-60 sm:pr-20"
            >
                <h2 class="relative z-30 mb-6 text-3xl font-bold text-white">{{ project.organization.name }}</h2>
                <div class="relative z-30 text-base text-white" v-text="project.organization.description" />
                <div class="relative z-30 mt-8">
                    <Link
                        class="bg-white block sm:inline text-center text-gray-900 focus-visible:outline-white rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        :href="route('organizations.show', project.organization)"
                    >
                        {{ $t('find_organization') }}
                    </Link>
                </div>

                <LargeSquarePattern class="absolute top-0 right-0 z-10 hidden sm:block fill-primary-600" />

                <LargeSquarePattern class="absolute left-0 z-10 -bottom-20 fill-primary-600" />
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
    /** Import form vue */
    import { ref } from 'vue';

    /** Import from inertia. */
    import { Head, Link, usePage, useForm } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import DonateModal from '@/Components/modals/DonateModal.vue';
    import VolunteerModal from '@/Components/modals/VolunteerModal.vue';
    import HowCanYouHelp from '@/Components/HowCanYouHelp.vue';
    import SharePage from '@/Components/SharePage.vue';
    import LargeSquarePattern from '@/Components/patterns/LargeSquarePattern.vue';
    import { ExternalLinkIcon, BookmarkIcon, LightningBoltIcon, ChartBarIcon } from '@heroicons/vue/outline';
    import { LocationMarkerIcon, CalendarIcon } from '@heroicons/vue/solid';
    import Gallery from '@/Components/Gallery.vue';

    const props = defineProps({
        project: {
            type: Object,
            required: true,
        },
    });
</script>
