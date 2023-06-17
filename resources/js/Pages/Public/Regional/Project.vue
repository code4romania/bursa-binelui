<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head title="Proiect" />

        <!-- Header -->
        <div class="flex flex-col-reverse w-full mx-auto mt-2 mb-8 lg:flex-row lg:max-w-7xl sm:mt-0 px-9">
            <div class="flex flex-col justify-center w-full lg:w-6/12">

                <div class="flex gap-6 pt-4 mr-6 bg-white">
                    <div class="flex items-center gap-2">
                        <div :class="['w-8 h-8 rounded-lg flex items-center justify-center', project.active ? 'bg-red-500' : 'bg-cyan-900']">
                            <SvgLoader :class="['shrink-0 stroke-white', project.active ? 'fill-red-500' : 'fill-cyan-900']" name="thunder" />
                        </div>
                        <p class="text-base font-semibold leading-6 text-gray-900">{{ project.active ? $t('active') : $t('inactive') }}</p>
                    </div>

                    <div v-if="project.category" class="flex items-center gap-2">
                        <div class="flex items-center justify-center rounded-lg bg-turqoise-50 w-9 h-9">
                            <SvgLoader class="shrink-0 fill-turqoise-50 stroke-turqoise-500" name="badge" />
                        </div>
                        <p class="w-40 text-base font-semibold leading-6 text-gray-900 truncate lg:w-60">{{ project.category}}</p>
                    </div>
                </div>

                <h1 v-if="project.name" class="py-12 text-6xl font-extrabold text-gray-900">{{ project.name }}</h1>

                <div class="flex flex-col w-full gap-4 sm:flex-row">

                    <!-- Donate modal -->
                    <DonateModal
                        v-if="project.is_period_active"
                        triggerModalClasses="bg-turqoise-500 w-full sm:w-auto hover:bg-turqoise-400 text-white focus-visible:outline-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        :triggerModalText="$t('donate_btn')"
                        :data="project"
                    />

                    <!-- Donate Error modal -->
                    <Modal
                        v-if="project.is_period_active ===false"
                        triggerModalClasses="bg-turqoise-500 w-full sm:w-auto hover:bg-turqoise-400 text-white focus-visible:outline-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        :triggerModalText="$t('donate_btn')"
                        id="project-donation-expired"
                    >
                        <div class="w-full mt-6">
                            <h3 class="text-xl font-semibold text-center text-gray-800">{{ $t('donation_period_ended') }}</h3>
                            <h3 class="text-xl font-semibold text-center text-turqoise-500">{{ $t('donate_to_other_projects') }}</h3>
                            <Link
                                :href="route('projects')"
                                class="rounded-md block mt-6 text-center bg-turqoise-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm"
                            >
                                {{ $t('see_other_projects') }}
                            </Link>
                        </div>
                    </Modal>

                    <!-- Volunteer modal -->
                    <VolunteerModal
                        v-if="project.accepting_volunteers"
                        triggerModalClasses="rounded-md w-full sm:w-auto bg-white text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 px-3.5 py-2.5"
                        :triggerModalText="$t('become_volunter')"
                        :data="project"
                    />
                </div>
            </div>

            <div class="relative items-center justify-center hidden w-full p-20 lg:w-6/12 sm:flex">

                <div class="absolute bottom-0 right-0">
                    <SvgLoader class="shrink-0" name="dotted_square" />
                </div>

                <div class="relative flex items-center p-8 bg-white rounded shadow w-fit">
                    <img class="mx-auto" src="/images/project_img.png" alt="" />
                </div>
            </div>
        </div>

        <!-- Target amount -->
        <div class="py-10 mb-20 bg-gray-100">
            <div class="w-full mx-auto lg:max-w-7xl px-9">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center rounded-lg bg-turqoise-500 w-9 h-9">
                        <SvgLoader class="fill-turqoise-500 shrink-0" name="brand_icon" />
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $t('target_amount') }}</h3>
                </div>

                <div class="mt-8">
                    <div class="flex items-center justify-between mb-1 text-xl font-bold">
                        <p class="text-cyan-900">
                            {{ project.total_donations }} {{ $t("currency") }}
                        </p>
                        <p class="text-turqoise-500">
                            {{ project.target_budget }} {{ $t("currency") }}
                        </p>
                    </div>

                    <div class="w-full h-6 bg-gray-300">
                        <div
                            :class="[`h-6`,project.total_donations == project.target_budget ? 'bg-turqoise-500' : 'bg-cyan-900',]"
                            :style="`width: ${percentage}%`"
                        ></div>
                    </div>

                    <p class="mt-1 text-xl font-bold text-cyan-900">{{ project.donations.length }} {{ $t('donations') }}</p>
                </div>
            </div>
        </div>

        <div class="relative flex items-center w-full mb-20 bg-white rounded shadow sm:hidden">
            <img class="mx-auto" src="/images/project_img.png" alt="" />
        </div>

        <!-- Social share -->
        <div class="flex flex-col mx-auto mb-8 lg:flex-row max-w-7xl px-9">
            <div class="w-full lg:w-6/12">

                <h2 class="mb-8 text-3xl font-bold text-cyan-900">{{ $t('share_project') }}</h2>

                <SharePage
                    class="mb-20"
                    id="1"
                    pageRoute="project"
                />

                <div class="mb-10" v-if="project.description">
                    <h2 class="mb-6 text-3xl font-bold text-cyan-900">{{ $t('description') }}</h2>
                    <div class="text-lg text-gray-500" v-html="project.description"></div>
                </div>
            </div>

            <div class="w-full mt-4 lg:w-6/12 lg:mt-0 lg:px-10">
                <div class="bg-white shadow-lg">

                    <div class="px-10 pt-10 pb-8 border-b border-gray-200">
                        <h3 class="text-4xl font-bold leading-6 text-gray-900">{{ $t('project_details') }}</h3>
                    </div>

                    <div class="px-10 py-8 space-y-8 bg-gray-50">

                        <div class="flex justify-start gap-x-4">
                            <SvgLoader class="mt-1 shrink-0 fill-turqoise-500" name="location" />
                            <div>
                                <h3 class="text-base font-semibold text-gray-600 leading-0">{{ $t('range') }}</h3>
                                <p class="mt-2 text-base font-normal text-gray-500"> {{ project.county.name }}</p>
                            </div>
                        </div>

                        <div class="flex justify-start gap-x-4">
                            <SvgLoader class="mt-1 shrink-0 fill-turqoise-500 stroke-turqoise-500" name="calendar" />
                            <div>
                                <h3 class="text-base font-semibold text-gray-600 leading-0">{{ $t('period') }}</h3>
                                <p class="mt-2 text-base font-normal text-gray-500">{{ project.start }} - {{ project.end }}</p>
                                <p v-if="(5 >= project.end) && (0 < project.end)" class="mt-1 text-base font-semibold text-turqoise-500">{{ $t('project_ends') }} {{ project.end }} {{ $t('days') }}!</p>
                            </div>
                        </div>

                        <!-- Donate modal -->
                        <DonateModal
                            triggerModalClasses="bg-turqoise-500 w-full hover:bg-turqoise-400 text-white focus-visible:outline-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                            :triggerModalText="$t('donate_btn')"
                            :data="project"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- Project info -->
        <div class="mx-auto mb-8 max-w-7xl px-9">

            <div class="mb-10" v-if="project.scope">
                <h2 class="mb-6 text-3xl font-bold text-cyan-900">{{ $t('project_scope_label') }}</h2>
                <div  class="text-lg text-gray-500" v-html="project.scope"></div>
            </div>

            <div class="mb-10" v-if="project.beneficiaries">
                <h2 class="mb-6 text-3xl font-bold text-cyan-900">{{ $t('project_beneficiary_label') }}</h2>
                <div  class="text-lg text-gray-500" v-html="project.beneficiaries"></div>
            </div>

            <div class="mb-10" v-if="project.reason_to_donate">
                <h2 class="mb-6 text-3xl font-bold text-cyan-900">{{ $t('why_to_donate') }}</h2>
                <div  class="text-lg text-gray-500" v-html="project.reason_to_donate"></div>
            </div>
        </div>

        <!-- How can you help -->
        <HowCanYouHelp
            class="mb-20"
            id="1"
            pageRoute="project"
            @donate="triggerDonate"
            @volunteer="triggerVolunteer"
            @copyCode="copyEmbed"

        />

        <!-- Gallery -->
        <div class="mb-24 bg-gray-100">
            <div class="flex flex-col w-full gap-8 py-10 mx-auto sm:flex-row lg:max-w-7xl px-9">

                <div class="flex-col justify-between w-full sm:flex">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center rounded-lg bg-turqoise-500 w-9 h-9">
                            <SvgLoader class="fill-turqoise-500 shrink-0" name="brand_icon" />
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $t('gallery') }}</h3>
                    </div>

                    <div class="mt-10 overflow-hidden rounded-lg group aspect-w-2 aspect-h-1">
                        <img src="https://images.unsplash.com/photo-1508779544523-dd1b27685be3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="" class="object-cover object-center group-hover:opacity-75" />
                        <div aria-hidden="true" class="bg-gradient-to-b from-transparent to-black opacity-90 sm:absolute sm:inset-0" />
                        <div class="flex items-center justify-center p-6 sm:absolute sm:inset-0">
                            <h3 class="flex items-center gap-4 font-semibold text-center text-white">
                                <SvgLoader name="play"/>
                                {{ $t('play_video') }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="w-full">
                    <div class="grid grid-cols-1 mt-6 gap-y-6 sm:grid-cols-2 sm:grid-rows-2 sm:gap-x-6 lg:gap-8">
                        <div class="h-full overflow-hidden rounded-lg group aspect-h-1 aspect-w-2 sm:aspect-h-3 sm:row-span-2">
                            <img src="https://images.unsplash.com/photo-1523115191856-c203e76215a5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=765&q=80" alt="" class="object-cover object-center group-hover:opacity-75" />
                        </div>

                        <div class="overflow-hidden rounded-lg group aspect-h-1 aspect-w-2 sm:aspect-none sm:relative sm:h-full">
                            <img src="https://images.unsplash.com/photo-1617450365226-9bf28c04e130?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="" class="object-cover object-center group-hover:opacity-75 sm:absolute sm:inset-0 sm:h-full sm:w-full" />
                        </div>

                        <div class="overflow-hidden rounded-lg group aspect-h-1 aspect-w-2 sm:aspect-none sm:relative sm:h-full">
                            <img src="https://images.unsplash.com/photo-1535090467336-9501f96eef89?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1500&q=80" alt="" class="object-cover object-center group-hover:opacity-75 sm:absolute sm:inset-0 sm:h-full sm:w-full" />
                            <div aria-hidden="true" class="bg-gradient-to-b from-transparent to-black opacity-90 sm:absolute sm:inset-0" />
                            <div class="flex items-center justify-center p-6 sm:absolute sm:inset-0">
                                <Link
                                    class="font-semibold text-center text-white"
                                    :href="route('gallery', project.id)"
                                >
                                    {{ $t('see_more') }}
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col-reverse items-center w-full py-10 mx-auto mb-24 sm:flex-row sm:max-w-7xl sm:pr-20">

            <div class="w-10/12 sm:w-3/12">
                <img class="relative z-50 flex-shrink-0 w-full mx-auto shadow-lg -mt-36 sm:mt-0 sm:-mr-36 rounded-xl" :src="project.organization.cover_image" alt="" />
            </div>

            <div class="relative z-30 w-11/12 h-full p-8 py-20 overflow-hidden bg-turqoise-500 rounded-xl pb-60 sm:pb-10 sm:pl-60 sm:pr-20">
                <h2 class="relative z-30 mb-6 text-3xl font-bold text-white">{{ project.organization.name }}</h2>
                <div class="relative z-30 text-base text-white" v-html="project.organization.description"></div>
                <div class="relative z-30 mt-8">
                    <Link
                        class="bg-white block sm:inline text-center text-gray-900 focus-visible:outline-white rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        :href="route('organization', project.organization.id)"
                    >
                        {{ $t('find_organization') }}
                    </Link>
                </div>

                <div class="absolute top-0 right-0 z-10 hidden sm:block">
                    <SvgLoader class="shrink-0" name="dotted_square" />
                </div>

                <div class="absolute left-0 z-10 -bottom-20">
                    <SvgLoader class="shrink-0" name="dotted_square" />
                </div>
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
    /** Import form vue */
    import {computed, onMounted, ref} from 'vue';

    /** Import from inertia. */
    import { Head, Link, usePage, useForm } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Modal from '@/Components/modals/Modal.vue';
    import DonateModal from '@/Components/modals/DonateModal.vue';
    import VolunteerModal from '@/Components/modals/VolunteerModal.vue';
    import HowCanYouHelp from '@/Components/HowCanYouHelp.vue';
    import SharePage from '@/Components/SharePage.vue';

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




    /** Percentage */
    const percentage = computed( () => (project.current_amount / project.max_amount) * 100 );

    /** Get days till project ends. */
    const project_end_date = computed(() => {
        const targetDate = new Date(project.period_end);
        const today = new Date();
        const timeDiff = targetDate.getTime() - today.getTime();
        const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

        return daysDiff;
    })

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
    const triggerDonate = (() => {
        console.log(0>project_end_date.value);
        if (0 >= project_end_date.value) {
            document.getElementById('project-donation-expired').click();
            return;
        }

        document.getElementById('donate-active-modal').click();
    });
</script>
