<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('thank_you')" />

        <div v-if="$page.props.auth.user" class="mx-auto my-10 space-y-10 max-w-7xl">
            <div class="flex gap-10">
                <div class="w-full md:w-1/2">
                    <!-- Header -->
                    <header class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                            <SvgLoader class="fill-primary-500 shrink-0" name="brand_icon" />
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $t('thank_you') }}</h2>
                    </header>

                    <p class="mt-8 text-lg font-medium text-gray-500">{{ $t('reward_auth') }}</p>

                    <div v-if="badge" class="flex items-center col-span-12 gap-6 md:col-span-6">
                        <img :src="`/images/badges/${badge.name}.png`" alt="" />
                        <div class="pr-4 space-y-6 text-gray-500">
                            <h3 class="text-lg font-bold">{{ $t(`${badge.title}`) }}</h3>
                            <p class="text-sm">{{ $t(`${badge.description}`) }}</p>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/2 lg:px-10">
                    <div class="bg-white shadow-lg">
                        <div class="p-8 space-y-8">
                            <div
                                class="inline-flex items-center justify-start px-3 py-1 text-base font-semibold rounded-full cursor-pointer text-primary-500 bg-primary-50"
                            >
                                {{ $t('woohoo') }}
                            </div>
                            <h3 class="text-6xl font-bold leading-6 text-gray-900">{{ donation.place }}</h3>
                            <p class="text-lg text-gray-500">
                                {{ $t('donations_place_1') }} {{ donation.place }} {{ $t('donations_place_2') }}
                            </p>
                        </div>

                        <div class="px-10 py-8 space-y-6 bg-gray-50">
                            <div
                                v-for="info in profile.donations_status"
                                class="flex items-center justify-start gap-x-4"
                            >
                                <SvgLoader class="shrink-0 fill-gray-50" name="check" />
                                <p class="text-base font-normal text-gray-500">{{ info }}</p>
                            </div>

                            <div class="w-full">
                                <Link
                                    :href="route('donor.donations')"
                                    class="rounded-md block text-center px-3.5 py-2.5 text-sm text-white font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 bg-primary-500"
                                >
                                    {{ $t('see_all_donations') }}
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="mx-auto mb-10 p-9 max-w-7xl">
            <div class="flex flex-col w-full gap-6 sm:flex-row">
                <div class="w-full sm:w-6/12">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center rounded-lg bg-primary-500 w-9 h-9">
                            <SvgLoader class="fill-primary-500 shrink-0" name="brand_icon" />
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $t('thank_you') }}</h1>
                    </div>

                    <p class="mt-8 text-lg font-medium text-gray-500">{{ $t('reward') }}</p>

                    <div class="mt-8">
                        <Link
                            :href="route('register')"
                            class="bg-primary-500 w-full sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        >
                            {{ $t('create_account') }}
                        </Link>
                    </div>
                </div>

                <div class="justify-end hidden w-full lg:w-6/12 sm:flex">
                    <img class="object-fill w-full h-full" src="/images/badges.png" alt="" />
                </div>
            </div>
        </div>

        <HowCanYouHelp
            v-if="project"
            class="mb-20"
            :pageRoute="route('projects.show', project.slug)"
            @donate="triggerDonate"
            @volunteer="triggerVolunteer"
            @copyCode="copyEmbed"
            :acceptsVolunteers="project.accepting_volunteers"
        />

        <!-- Donate modal -->
        <DonateModal triggerModalClasses="h-0" triggerModalText="" :data="project" />

        <!-- Volunteer modal -->
        <VolunteerModal triggerModalClasses="h-0" triggerModalText="" :data="project" />
    </PageLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { Head, Link } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import DonateModal from '@/Components/modals/DonateModal.vue';
    import VolunteerModal from '@/Components/modals/VolunteerModal.vue';
    import HowCanYouHelp from '@/Components/HowCanYouHelp.vue';

    const props = defineProps({
        project: Object,
    });

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
        document.getElementById('donate-active-modal').click();
    };
</script>
