<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head title="Organizatie" />

        <div class="bg-white mt-4 mb-20">

            <!-- Header -->
            <div class="flex flex-col-reverse lg:flex-row mx-auto w-full lg:max-w-7xl mb-8 px-9">
                <div class="w-full lg:w-6/12 flex flex-col justify-center xl:pr-6">

                    <div class="border-b border-gray-200 bg-white mr-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-turqoise-500 w-9 h-9 rounded-lg flex items-center justify-center">
                                <SvgLoader class="shrink-0 fill-turqoise-500 stroke-turqoise-500" name="global" />
                            </div>
                            <h3 class="text-base font-semibold leading-6 text-gray-900">{{organization.counties.join(', ')}}</h3>
                        </div>
                    </div>

                    <h1 class="text-6xl font-extrabold text-gray-900 py-12">{{ organization.name }}</h1>

                    <div class="flex items-center gap-4">
                        <Link
                            :href="route('projects')"
                            class="text-center inline text-white bg-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm"
                        >
                            {{ $t('see_projects') }}
                        </Link>

                        <!-- Volunteer modal -->
                        <VolunteerModal
                            triggerModalClasses="rounded-md bg-white text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 px-3.5 py-2.5"
                            :triggerModalText="$t('become_volunter')"
                            :data="organization"
                        />
                    </div>
                </div>

                <div class="w-full lg:w-6/12 relative p-20 flex items-center justify-center">

                    <div class="w-full h-full absolute top-0 left-0">
                        <img class="w-full h-full" src="/images/ong_bg.png" alt="" />
                    </div>

                    <div class="p-8 bg-white w-fit rounded shadow relative flex items-center">
                        <img class="mx-auto" src="/images/ong.png" alt="" />
                    </div>
                </div>
            </div>

            <!-- Soacial share -->
            <div class="flex flex-col lg:flex-row mx-auto max-w-7xl mb-8 px-9">
                <div class="w-full lg:w-6/12">

                    <h2 class="text-cyan-900 text-3xl font-bold mb-8">{{ $t('share_page') }}</h2>
                    <SharePage
                        class="mb-20"
                        :id="organization.id"
                        pageRoute="organization"
                    />

                    <div v-if="organization.activity_domains">
                        <h2 class="text-cyan-900 text-3xl font-bold mb-8">{{ $t('activity_domains') }}</h2>
                        <div class="text-gray-500 text-lg mb-12" v-html="organization.activity_domains.join(', ')"></div>
                    </div>

                    <div v-if="organization.description">
                        <h2 class="text-cyan-900 text-3xl font-bold mb-8">{{ $t('description') }}</h2>
                        <div  class="text-gray-500 text-lg" v-html="organization.description"></div>
                    </div>
                </div>

                <div class="w-full lg:w-6/12 mt-4 lg:mt-0 lg:px-10">
                    <div class="shadow-lg bg-white">

                        <div class="border-b border-gray-200 px-10 pt-10 pb-8">
                            <h3 class="text-4xl font-bold leading-6 text-gray-900">{{ $t('ong_contact') }}</h3>
                        </div>

                        <div class="bg-gray-50 px-10 py-8 space-y-8">

                            <div v-if="organization.contact_person" class="flex justify-start gap-x-4">
                                <SvgLoader class="shrink-0 mt-1" name="home" />
                                <div>
                                    <h3 class="text-gray-600 font-semibold text-base">{{ $t('ong_address') }}</h3>
                                    <p class="mt-2 text-gray-500 font-normal text-base">{{ organization.street_address }}, <br> {{ organization.county_name }}, {{ organization.city_name }}</p>
                                </div>
                            </div>

                            <div v-if="organization.contact_person" class="flex justify-start gap-x-4">
                                <SvgLoader class="shrink-0 mt-1" name="email" />
                                <div>
                                    <h3 class="text-gray-600 font-semibold text-base">{{ $t('email') }}</h3>
                                    <p class="mt-2 text-gray-500 font-normal text-base">{{ organization.contact_email }}</p>
                                </div>
                            </div>

                            <div v-if="organization.contact_person" class="flex justify-start gap-x-4">
                                <SvgLoader class="shrink-0 mt-1" name="person" />
                                <div>
                                    <h3 class="text-gray-600 leading-0 font-semibold text-base">{{ $t('contact_person') }}</h3>
                                    <p class="mt-2 text-gray-500 font-normal text-base">{{ organization.contact_person }}</p>
                                </div>
                            </div>

                            <a
                                v-if="organization.website"
                                :href="organization.website"
                                class="block text-center text-white bg-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                            >
                                {{ $t('see_website') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Projects -->
            <div class="bg-gray-50 px-9">
                <div class="mx-auto max-w-7xl flex items-center gap-4 py-12">
                    <div class="bg-turqoise-500 w-9 h-9 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0 fill-turqoise-500 stroke-turqoise-500" name="brand_icon" />
                    </div>
                    <h3 class="text-gray-900 font-bold text-2xl">{{ $t('ong_projects') }}</h3>
                </div>
            </div>

            <div class="bg-white px-9">
                <ul role="list" class="mx-auto max-w-7xl grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                    <template v-for="(item, index) in organization.projects" :key="index">
                        <ProjectCard
                            class="-mt-6"
                            :data="item"
                            cardType="client"
                        />
                    </template>
                </ul>
            </div>

            <!-- How can you help -->
            <HowCanYouHelp
                class="mb-20"
                :id="organization.id"
                pageRoute="organization"
                @donate="triggerDonate"
                @volunteer="triggerVolunteer"
                @copyCode="copyEmbed"

            />
        </div>

        <!-- Donate modal -->
        <DonateModal
            triggerModalClasses="h-0"
            triggerModalText=""
            :data="organization"
        />
    </PageLayout>
</template>

<script setup>
    /** Remove this import after backend connection. */
    import projects from '@/local_json/projects.js';

    /** Import from inertia. */
    import { Head, Link, usePage } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import ProjectCard from '@/Components/cards/ProjectCard.vue';
    import DonateModal from '@/Components/modals/DonateModal.vue';
    import VolunteerModal from '@/Components/modals/VolunteerModal.vue';
    import SharePage from '@/Components/SharePage.vue';
    import HowCanYouHelp from '@/Components/HowCanYouHelp.vue';
    import {onMounted} from "vue";

    /** Page props. */
    const props = defineProps({
        organization: [Array, Object]
    });

    onMounted(() => {
        console.log(props.organization);
    });

    /**
     * Copy embed code.
     */
    const copyEmbed = () => {

        /** Embed iframe. */
        const embedCode = `<iframe src="${window.location.href}" width="800px" height="600px"></iframe>`;

        /** Check if navigator object exists and copy iframe. */
        if (navigator.clipboard) {
            navigator.clipboard.writeText(embedCode)
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
    }

    /** Trigger volunteer modal from card. */
    const triggerVolunteer = (() => { document.getElementById('volunteer-active-modal').click(); });

    /** Trigger donate modal from card. */
    const triggerDonate = (() => { document.getElementById('donate-active-modal').click(); });
</script>
