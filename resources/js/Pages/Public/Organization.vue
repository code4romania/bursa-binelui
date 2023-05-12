<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head title="Organizatie" />

        <div class="bg-white mb-20">
            <div class="flex flex-col-reverse lg:flex-row mx-auto w-full lg:max-w-7xl mb-8 px-9">
                <div class="w-full lg:w-6/12 flex flex-col justify-center xl:pr-6">

                    <div class="border-b border-gray-200 bg-white mr-6 py-4">
                        <div class="flex items-center gap-4">
                            <SvgLoader name="global" />
                            <h3 class="text-base font-semibold leading-6 text-gray-900">{{ organization.county_id }}, {{ organization.city_id }}</h3>
                        </div>
                    </div>

                    <h1 class="text-6xl font-extrabold text-gray-900 py-12">{{ organization.name }}</h1>

                    <div class="flex items-center gap-4">
                        <Link
                            href="route('projects')"
                            class="text-center text-white bg-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        >
                            {{ $t('see_projects') }}
                        </Link>

                        <Link
                            href="route('donate')"
                            class="rounded-md bg-white text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 px-3.5 py-2.5"
                        >
                            {{ $t('volunteer') }}
                        </Link>
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

            <div class="flex flex-col lg:flex-row mx-auto max-w-7xl mb-8 px-9">
                <div class="w-full lg:w-6/12">

                    <h2 class="text-cyan-900 text-3xl font-bold mb-8">{{ $t('share_page') }}</h2>
                    <div class="flex items-center gap-6 mb-12">
                        <a :href="`https://www.facebook.com/sharer/sharer.php?u=${route('organization', organization.id)}`" target="_blank" rel="noopener">
                            <SvgLoader class="shrink-0" name="facebook_colored" />
                        </a>

                        <a :href="`https://www.linkedin.com/sharing/share-offsite/?url=${route('organization', organization.id)}`" target="_blank" rel="noopener">
                            <SvgLoader class="shrink-0" name="linkedin_colored" />
                        </a>

                        <a :href="`https://api.whatsapp.com/send?text=${route('organization', organization.id)}`" data-action="share/whatsapp/share"   target="_blank" rel="noopener">
                            <SvgLoader class="shrink-0" name="whatsapp_colored" />
                        </a>


                        <SvgLoader @click="copyEmbed" class="shrink-0" name="embed_colored" />

                    </div>

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
                                    <p class="mt-2 text-gray-500 font-normal text-base">{{ organization.street_address }}, <br> {{ organization.county_id }}, {{ organization.city_id }}</p>
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
                    <SvgLoader class="shrink-0" name="brand_icon" />
                    <h3 class="text-gray-900 font-bold text-2xl">{{ $t('ong_projects') }}</h3>
                </div>
            </div>

            <div class="bg-white px-9">
                <ul role="list" class="mx-auto max-w-7xl grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                    <template v-for="(item, index) in projects" :key="index">
                        <ProjectCard class="-mt-6" :data="item">
                            <Link
                                href="route('projects')"
                                class="block text-center mt-8 text-white bg-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                            >
                                {{ $t('see_projects') }}
                            </Link>
                        </ProjectCard>
                    </template>
                </ul>
            </div>

            <div class="bg-turqoise-500 pt-12 pb-20 mt-16 px-9 lg:px-0">
                <div class="mx-auto max-w-7xl flex items-center gap-4">
                    <SvgLoader class="shrink-0" name="sound" />
                    <h3 class="text-white font-bold text-2xl">{{ $t('ong_projects') }}</h3>
                </div>
            </div>

            <div class="bg-white px-9">
                <ul role="list" class="mx-auto max-w-7xl grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                    <li class="col-span-1 -mt-12 p-6 flex flex-col rounded-md bg-white shadow-lg">
                        <SvgLoader name="share" />
                        <h3 class="mt-6 mb-2 text-lg font-medium text-gray-900">{{ $t('social_media_share') }}</h3>
                        <div class="text-sm text-gray-500">
                            {{  $t('share')  }}
                            <a class="text-blue-500 underline" :href="`https://www.facebook.com/sharer/sharer.php?u=${route('organization', organization.id)}`" target="_blank" rel="noopener">{{ $t('facebook') }}</a>,
                            <a class="text-blue-500 underline" :href="`https://www.instagram.com/create/story/?text=${route('organization', organization.id)}`" target="_blank" rel="noopener">{{ $t('instagram') }}</a>,
                            <a class="text-blue-500 underline" :href="`https://www.facebook.com/sharer/sharer.php?u=${route('organization', organization.id)}`" target="_blank" rel="noopener">{{ $t('linkedin') }}</a>,
                            {{ $t('send_to_friend') }}
                            <a class="text-blue-500 underline" :href="`https://api.whatsapp.com/send?text=${route('organization', organization.id)}`" data-action="share/whatsapp/share"   target="_blank" rel="noopener">{{ $t('whatsapp') }}</a>
                            {{ $t('or') }}
                            <a class="text-blue-500 underline" :href="`https://www.facebook.com/dialog/send?app_id=APP_ID&link=${route('organization', organization.id)}`" target="_blank" rel="noopener">{{ $t('messenger') }}</a>
                            {{ $t('tell_about') }}
                        </div>
                    </li>

                    <li class="col-span-1 -mt-12 p-6 flex flex-col rounded-md bg-white shadow-lg">
                        <SvgLoader name="heart" />
                        <h3 class="mt-6 mb-2 text-lg font-medium text-gray-900">{{ $t('donate_or_volunteer') }}</h3>
                        <div class="text-sm text-gray-500">
                            {{ $t('interested_in_ong') }}
                            <Link class="text-blue-500 underline" href="route('donate')">{{ $t('donate') }}</Link>
                            {{ $t('help_them') }}
                            <Link class="text-blue-500 underline" href="route('donate')">{{ $t('register_to_volunteer') }}</Link>
                            {{ $t('for_ong') }}
                        </div>
                    </li>

                    <li class="col-span-1 -mt-12 p-6 flex flex-col rounded-md bg-white shadow-lg">
                        <SvgLoader name="glob" />
                        <h3 class="mt-6 mb-2 text-lg font-medium text-gray-900">{{ $t('your_blog') }}</h3>
                        <div class="text-sm text-gray-500">
                            {{ $t('you_have_blog') }}
                            <a class="text-blue-500 underline" href="">{{ $t('embed_code') }}</a>
                            {{ $t('copy_code') }}
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
    /** Import form vue */
    import { computed } from 'vue';

    /** Import from inertia. */
    import { Head, Link, usePage } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import ProjectCard from '@/Components/cards/Card.vue'

    /** Page props. */
    const props = computed(() => usePage().props);

    /** Organizations. */
    const organization = computed(() => props.value ? props.value.organization : {});

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

    /** Grid list */
    const projects = [
        {
            name: 'Asociația MediuACUM',
            title: 'Ecologizarea canalului de la marginea Tulcei',
            county: "Alba Iulia",
            activity: "Mediu",
            currentAmount: "102200",
            maxAmount: "202200",
            status:"active",
            imageUrl:'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
        },

        {
            name: 'Asociația MediuACUM',
            title: 'Ecologizarea canalului de la marginea Tulcei',
            county: "Alba Iulia",
            activity: "Mediu",
            currentAmount: "102200",
            maxAmount: "202200",
            status:"draft",
            imageUrl:'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
        },

        {
            name: 'Asociația MediuACUM',
            title: 'Ecologizarea canalului de la marginea Tulcei',
            county: "Alba Iulia",
            activity: "Mediu",
            currentAmount: "102200",
            maxAmount: "202200",
            status:"active",
            imageUrl:'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
        },
    ];
</script>
