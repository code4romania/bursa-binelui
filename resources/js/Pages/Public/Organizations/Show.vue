<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head title="Organizatie" />

        <div class="mt-4 mb-20 bg-white">
            <!-- Header -->
            <div class="flex flex-col-reverse w-full mx-auto mb-8 lg:flex-row lg:max-w-7xl px-9">
                <div class="flex flex-col justify-center w-full lg:w-6/12 xl:pr-6">
                    <div class="py-4 mr-6 bg-white border-b border-gray-200">
                        <div class="flex items-center gap-4">
                            <GlobeAltIcon
                                class="flex items-center justify-center w-10 h-10 p-2 text-white rounded-lg bg-primary-500 shrink-0"
                            />

                            <span
                                class="text-base font-medium leading-6 text-gray-900"
                                v-text="organization.location"
                            />
                        </div>
                    </div>

                    <h1 class="py-12 text-6xl font-extrabold text-gray-900" v-text="organization.name" />

                    <div class="flex items-center gap-4">
                        <a
                            href="#projects"
                            class="text-center inline text-white bg-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm"
                        >
                            {{ $t('see_projects') }}
                        </a>

                        <!-- Volunteer modal -->
                        <VolunteerModal
                            triggerModalClasses="rounded-md bg-white text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 px-3.5 py-2.5"
                            :triggerModalText="$t('become_volunter')"
                            :data="organization"
                            :postUrl="route('organization.volunteer', organization.id)"
                        />
                    </div>
                </div>

                <div class="relative flex items-center justify-center w-full p-20 lg:w-6/12">
                    <div class="absolute top-0 left-0 w-full h-full">
                        <img class="w-full h-full" src="/images/ong_bg.png" alt="" />
                    </div>

                    <div class="relative flex items-center p-8 bg-white rounded shadow w-fit">
                        <img class="mx-auto" :src="organization.logo" alt="" />
                    </div>
                </div>
            </div>

            <!-- Soacial share -->
            <div class="flex flex-col mx-auto mb-8 lg:flex-row max-w-7xl px-9">
                <div class="w-full lg:w-6/12">
                    <h2 class="mb-8 text-3xl font-bold text-primary-900">{{ $t('share_page') }}</h2>
                    <SharePage class="mb-20" :pageRoute="route('organization', organization.id)" />

                    <div v-if="organization.activity_domains">
                        <h2 class="mb-8 text-3xl font-bold text-primary-900">{{ $t('activity_domains') }}</h2>
                        <div class="mb-12 text-lg text-gray-500" v-text="organization.activity_domains" />
                    </div>

                    <div v-if="organization.description">
                        <h2 class="mb-8 text-3xl font-bold text-primary-900">{{ $t('description') }}</h2>
                        <div class="text-lg text-gray-500" v-html="organization.description"></div>
                    </div>
                </div>

                <div class="w-full mt-4 lg:w-6/12 lg:mt-0 lg:px-10">
                    <div class="bg-white shadow-lg">
                        <div class="px-10 pt-10 pb-8 border-b border-gray-200">
                            <h3 class="text-4xl font-bold leading-6 text-gray-900">{{ $t('ong_contact') }}</h3>
                        </div>

                        <div class="px-10 py-8 space-y-8 bg-gray-50">
                            <div v-if="organization.contact_person" class="flex justify-start gap-x-4">
                                <SvgLoader class="mt-1 shrink-0" name="home" />
                                <div>
                                    <h3 class="text-base font-semibold text-gray-600">{{ $t('ong_address') }}</h3>
                                    <p class="mt-2 text-base font-normal text-gray-500">
                                        {{ organization.street_address }}<br/>  {{ organization.location }} <br />

                                    </p>
                                </div>
                            </div>

                            <div v-if="organization.contact_person" class="flex justify-start gap-x-4">
                                <SvgLoader class="mt-1 shrink-0" name="email" />
                                <div>
                                    <h3 class="text-base font-semibold text-gray-600">{{ $t('email') }}</h3>
                                    <p class="mt-2 text-base font-normal text-gray-500">
                                        {{ organization.contact_email }}
                                    </p>
                                </div>
                            </div>

                            <div v-if="organization.contact_person" class="flex justify-start gap-x-4">
                                <SvgLoader class="mt-1 shrink-0" name="person" />
                                <div>
                                    <h3 class="text-base font-semibold text-gray-600 leading-0">
                                        {{ $t('contact_person') }}
                                    </h3>
                                    <p class="mt-2 text-base font-normal text-gray-500">
                                        {{ organization.contact_person }}
                                    </p>
                                </div>
                            </div>

                            <a
                                v-if="organization.website"
                                :href="organization.website"
                                class="block text-center text-white bg-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                            >
                                {{ $t('see_website') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Projects -->
            <div id="projects" class="bg-gray-50 px-9">
                <div class="flex items-center gap-4 py-12 mx-auto max-w-7xl">
                    <ChartBarIcon
                        class="flex items-center justify-center w-10 h-10 p-2 rounded-lg shrink-0 stroke-white bg-primary-500"
                    />

                    <h3 class="text-2xl font-bold text-gray-900">{{ $t('ong_projects') }}</h3>
                </div>
            </div>

            <div class="bg-white px-9">
                <ul class="grid grid-cols-1 gap-8 mx-auto max-w-7xl sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                    <ProjectCard
                        v-for="(item, index) in organization.projects"
                        :key="index"
                        class="-mt-6"
                        :project="item"
                        cardType="client"
                    />
                </ul>
            </div>

            <!-- How can you help -->
            <HowCanYouHelp
                class="mb-20"
                :pageRoute="route('organization', organization.id)"
                @volunteer="triggerVolunteer"
                :acceptsVolunteers="organization.accepting_volunteers"
            />
        </div>

        <!-- Donate modal -->
        <DonateModal triggerModalClasses="h-0" triggerModalText="" :data="organization" />
    </PageLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { Head, Link } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import ProjectCard from '@/Components/cards/ProjectCard.vue';
    import DonateModal from '@/Components/modals/DonateModal.vue';
    import VolunteerModal from '@/Components/modals/VolunteerModal.vue';
    import SharePage from '@/Components/SharePage.vue';
    import HowCanYouHelp from '@/Components/HowCanYouHelp.vue';

    import { ChartBarIcon, GlobeAltIcon } from '@heroicons/vue/outline';

    /** Page props. */
    const props = defineProps({
        organization: [Array, Object],
    });

    /** Trigger volunteer modal from card. */
    const triggerVolunteer = () => {
        document.getElementById('volunteer-active-modal').click();
    };

    /** Trigger donate modal from card. */
    const triggerDonate = () => {
        document.getElementById('donate-active-modal').click();
    };
</script>
