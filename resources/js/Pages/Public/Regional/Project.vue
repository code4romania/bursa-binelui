<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head title="Proiect" />

        <!-- Header -->
        <div
            class="flex flex-col-reverse w-full mx-auto mb-10 px-9 lg:flex-row lg:items-start lg:justify-start max-w-7xl"
        >
            <div class="w-full lg:mt-16 lg:w-6/12">
                <div class="flex gap-6 pt-4 mb-8 mr-6 bg-white">
                    <div class="flex items-center gap-2">
                        <div
                            :class="[
                                'w-8 h-8 rounded-lg flex items-center justify-center',
                                project.active ? 'bg-red-500' : 'bg-primary-500',
                            ]"
                        >
                            <Icon class="w-4 h-6 stroke-2 shrink-0 stroke-white fill-transparent" name="thunder" />
                        </div>
                        <p class="text-base font-semibold leading-6 text-gray-900">
                            {{ project.active ? $t('active') : $t('inactive') }}
                        </p>
                    </div>

                    <div v-if="project.category" class="flex items-center gap-2">
                        <div class="flex items-center justify-center w-8 h-8 p-1 rounded-lg bg-primary-50">
                            <BookmarkIcon class="stroke-primary-400 shrink-0" />
                        </div>
                        <p class="w-40 text-base font-semibold leading-6 text-gray-900 truncate lg:w-60">
                            {{ project.category }}
                        </p>
                    </div>
                </div>

                <h1 v-if="project.name" class="text-6xl font-extrabold text-left text-gray-900">{{ project.name }}</h1>

                <div class="flex items-center justify-start w-full mt-4 text-2xl font-bold text-primary-900">
                    {{ project.organization.name }}
                </div>
            </div>

            <div class="relative items-center justify-center hidden w-full p-20 lg:w-6/12 sm:flex">
                <LargeSquarePattern class="absolute bottom-0 right- fill-primary-100" />

                <div class="relative flex items-center w-fit">
                    <img
                        class="mx-auto rounded-md shadow"
                        :src="
                            project.cover_image !== ''
                                ? project.cover_image
                                : 'https://images.unsplash.com/photo-1508779544523-dd1b27685be3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80'
                        "
                    />
                </div>
            </div>
        </div>

        <div class="relative flex items-center w-full mb-20 bg-white rounded shadow sm:hidden">
            <img class="mx-auto" src="/images/project_img.png" alt="" />
        </div>

        <!-- Social share -->
        <div class="flex flex-col mx-auto mb-8 lg:flex-row max-w-7xl px-9">
            <div class="w-full lg:w-6/12">
                <h2 class="mb-8 text-3xl font-bold text-primary-900">{{ $t('share_project') }}</h2>

                <SharePage class="mb-20" :pageRoute="route('projects.show', project.slug)" />

                <div class="mb-10" v-if="project.description">
                    <h2 class="mb-6 text-3xl font-bold text-primary-900">{{ $t('regional_description_label') }}</h2>
                    <div class="text-lg text-gray-500" v-text="project.description" />
                </div>
            </div>

            <div class="w-full mt-4 lg:w-6/12 lg:mt-0 lg:px-10">
                <div class="bg-white shadow-lg">
                    <div class="px-10 pt-10 pb-8 border-b border-gray-200">
                        <h3 class="text-4xl font-bold leading-6 text-gray-900">{{ $t('project_details') }}</h3>
                    </div>

                    <div class="px-10 py-8 space-y-8 bg-gray-50">
                        <div class="flex justify-start gap-x-4">
                            <LocationMarkerIcon class="w-5 h-5 shrink-0 fill-primary-500" />
                            <div>
                                <h3 class="text-base font-semibold text-gray-600 leading-0">{{ $t('range') }}</h3>
                                <p class="mt-2 text-base font-normal text-gray-500">{{ project?.county?.name }}</p>
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

                        <div class="flex justify-start gap-x-4">
                            <UserIcon class="w-5 h-5 shrink-0 fill-primary-500" />
                            <div>
                                <h3 class="text-base font-semibold text-gray-600 leading-0">
                                    {{ $t('contact_person') }}
                                </h3>
                                <p v-if="project?.contact?.name" class="mt-2 text-base font-normal text-gray-500">
                                    {{ project.contact.name }}
                                </p>
                                <p v-if="project?.contact?.job" class="mt-2 text-base font-normal text-gray-500">
                                    {{ project.contact.job }}
                                </p>
                                <p v-if="project?.contact?.phone" class="mt-2 text-base font-normal text-gray-500">
                                    {{ project.contact.phone }}
                                </p>
                                <p v-if="project?.contact?.email" class="mt-2 text-base font-normal text-gray-500">
                                    {{ project.contact.email }}
                                </p>
                            </div>
                        </div>

                        <!-- Donate modal -->
                        <DonateModal
                            triggerModalClasses="bg-primary-500 w-full hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                            :triggerModalText="$t('donate_btn')"
                            :data="project"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- Project info -->
        <div class="mx-auto mb-8 max-w-7xl px-9">
            <div class="mb-10" v-if="project.needs">
                <h2 class="mb-6 text-3xl font-bold text-primary-900">{{ $t('regional_needs_label') }}</h2>
                <div class="text-lg text-gray-500" v-text="project.needs" />
            </div>

            <div class="mb-10" v-if="project.solution">
                <h2 class="mb-6 text-3xl font-bold text-primary-900">{{ $t('regional_solution_label') }}</h2>
                <div class="text-lg text-gray-500" v-text="project.solution" />
            </div>

            <div class="mb-10" v-if="project.stats">
                <h2 class="mb-6 text-3xl font-bold text-primary-900">{{ $t('regional_project_stats_label') }}</h2>
                <div class="text-lg text-gray-500" v-text="project.stats" />
            </div>

            <div class="mb-10" v-if="project.results">
                <h2 class="mb-6 text-3xl font-bold text-primary-900">{{ $t('regional_results_label') }}</h2>
                <div class="text-lg text-gray-500" v-text="project.results" />
            </div>

            <div class="mb-10" v-if="project.proud">
                <h2 class="mb-6 text-3xl font-bold text-primary-900">{{ $t('regional_proud_label') }}</h2>
                <div class="text-lg text-gray-500" v-text="project.proud" />
            </div>

            <div class="mb-10" v-if="project.parteners">
                <h2 class="mb-6 text-3xl font-bold text-primary-900">{{ $t('parteners') }}</h2>
                <div class="text-lg text-gray-500" v-text="project.parteners" />
            </div>

            <div class="mb-10" v-if="project.budget">
                <h2 class="mb-6 text-3xl font-bold text-primary-900">{{ $t('regional_budget_label') }}</h2>
                <div class="text-lg text-gray-500" v-text="project.budget" />
            </div>

            <div class="mb-10" v-if="project.participants">
                <h2 class="mb-6 text-3xl font-bold text-primary-900">{{ $t('regional_participants_no_label') }}</h2>
                <div class="text-lg text-gray-500" v-text="project.participants" />
            </div>

            <div class="mb-10" v-if="project.project_organization">
                <h2 class="mb-6 text-3xl font-bold text-primary-900">{{ $t('regional_organization_label') }}</h2>
                <div class="text-lg text-gray-500" v-text="project.project_organization" />
            </div>
        </div>

        <!-- How can you help -->
        <HowCanYouHelp
            class="mb-20"
            :pageRoute="route('projects.show', project.slug)"
            :acceptsVolunteers="project.accepting_volunteers"
        />

        <!-- Gallery -->
        <div class="w-full bg-gray-100">
            <div class="mx-auto max-w-7xl">
                <Gallery v-if="gallery.length" :gallery="gallery" />
            </div>
        </div>

        <div class="flex flex-col-reverse items-center w-full py-10 mx-auto mb-24 sm:flex-row sm:max-w-7xl sm:pr-20">
            <div class="w-10/12 sm:w-3/12">
                <img
                    class="relative z-50 flex-shrink-0 w-full mx-auto shadow-lg -mt-36 sm:mt-0 sm:-mr-36 rounded-xl"
                    :src="project.organization.cover_image"
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
                        :href="route('organizations.show', project.organization.slug)"
                    >
                        {{ $t('find_organization') }}
                    </Link>
                </div>

                <LargeSquarePattern
                    class="absolute right-0 z-10 hidden overflow-hidden -top-32 sm:block fill-gray-300"
                />

                <LargeSquarePattern class="absolute z-10 overflow-hidden -left-10 -bottom-24 fill-gray-300" />
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { Link } from '@inertiajs/vue3';
    import Head from '@/Components/Head.vue';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Icon from '@/Components/Icon.vue';

    import DonateModal from '@/Components/modals/DonateModal.vue';
    import HowCanYouHelp from '@/Components/HowCanYouHelp.vue';
    import SharePage from '@/Components/SharePage.vue';
    import Gallery from '@/Components/Gallery.vue';
    import { BookmarkIcon, LocationMarkerIcon, CalendarIcon, UserIcon } from '@heroicons/vue/outline';
    import LargeSquarePattern from '@/Components/patterns/LargeSquarePattern.vue';

    const props = defineProps({
        project: {
            type: Object,
            required: true,
        },
        gallery: {
            type: Array,
            default: () => [],
        },
    });

    /** Trigger donate modal from card. */
    const triggerDonate = () => {
        if (0 >= project_end_date.value) {
            document.getElementById('project-donation-expired').click();
            return;
        }

        document.getElementById('donate-active-modal').click();
    };
</script>
