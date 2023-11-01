<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('thank_you')" />

        <div class="mx-auto mb-10 p-9 max-w-7xl">
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
                            v-if="!$page.props.auth.user"
                            :href="route('register')"
                            class="bg-primary-500 w-full sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        >
                            {{ $t('create_account') }}
                        </Link>

                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('donor.index')"
                            class="bg-primary-500 w-full sm:w-auto hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        >
                            {{ $t('dashbord') }}
                        </Link>
                    </div>
                </div>

                <div class="justify-end hidden w-full lg:w-6/12 sm:flex">
                    <img class="object-fill w-full h-full" src="/images/badges.png" alt="" />
                </div>
            </div>
        </div>

        <HowCanYouHelp
            class="mb-20"
            :pageRoute="route('projects.show', 1)"
            @donate="triggerDonate"
            @volunteer="triggerVolunteer"
            @copyCode="copyEmbed"
            :acceptsVolunteers="flash?.data.accepting_volunteers"
        />

        <!-- Donate modal -->
        <DonateModal triggerModalClasses="h-0" triggerModalText="" :data="flash?.data" />

        <!-- Volunteer modal -->
        <VolunteerModal triggerModalClasses="h-0" triggerModalText="" :data="flash?.data" />
    </PageLayout>
</template>

<script setup>
    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import DonateModal from '@/Components/modals/DonateModal.vue';
    import VolunteerModal from '@/Components/modals/VolunteerModal.vue';
    import HowCanYouHelp from '@/Components/HowCanYouHelp.vue';

    const props = defineProps({
        flash: Object,
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
