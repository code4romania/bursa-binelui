<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('thank_you')" />

        <div class="p-9 mx-auto max-w-7xl mb-10">

            <div class="flex w-full flex-col sm:flex-row gap-6">
                <div class="w-full sm:w-6/12">

                    <div class="flex items-center gap-4">
                        <div class="bg-turqoise-500 w-9 h-9 rounded-lg flex items-center justify-center">
                            <SvgLoader class="fill-turqoise-500 shrink-0" name="brand_icon" />
                        </div>
                        <h1 class="text-gray-900 font-bold text-2xl">{{ $t('thank_you') }}</h1>
                    </div>

                    <p class="mt-8 text-lg text-gray-500 font-medium">{{ $t('reward') }}</p>

                    <div class="mt-8">
                        <Link
                            :href="route('register')"
                            class="bg-turqoise-500 w-full sm:w-auto hover:bg-turqoise-400 text-white focus-visible:outline-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        >
                            {{ $t('create_account') }}
                        </Link>
                    </div>
                </div>

                <div class="w-full lg:w-6/12 hidden sm:flex justify-end">
                    <img class="w-full h-full object-fill" src="/images/badges.png" alt="" />
                </div>
            </div>
        </div>

        <HowCanYouHelp
            class="mb-20"
            :id="project.id"
            pageRoute="organization"
            @donate="triggerDonate"
            @volunteer="triggerVolunteer"
            @copyCode="copyEmbed"
        />

        <!-- Donate modal -->
        <DonateModal
            triggerModalClasses="h-0"
            triggerModalText=""
            :data="project"
        />

        <!-- Volunteer modal -->
        <VolunteerModal
            triggerModalClasses="h-0"
            triggerModalText=""
            :data="project"
        />
    </PageLayout>
</template>

<script setup>
    /** Remove this import after backend connection. */
    import project from '@/local_json/project.js';

    /** Import from inertia. */
    import { Head, Link } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import DonateModal from '@/Components/modals/DonateModal.vue';
    import VolunteerModal from '@/Components/modals/VolunteerModal.vue';
    import HowCanYouHelp from '@/Components/HowCanYouHelp.vue';

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
