<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head title="Proiect" />

        <div class="bg-white mb-20">

            <div class="flex flex-col-reverse lg:flex-row mx-auto w-full lg:max-w-7xl mb-8 px-9">
                <div class="w-full lg:w-6/12 flex flex-col justify-center xl:pr-6">

                    <div class="border-b border-gray-200 bg-white mr-6 py-4">
                        <div class="flex items-center gap-4">
                            <SvgLoader name="global" />
                            <h3 class="text-base font-semibold leading-6 text-gray-900">{{ project.county_name }}, {{ project.city_name }}</h3>
                        </div>
                    </div>

                    <h1 class="text-6xl font-extrabold text-gray-900 py-12">{{ project.name }}</h1>

                    <div class="flex items-center gap-4">
                        <Link
                            href="route('projects')"
                            class="text-center text-white bg-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        >
                            {{ $t('donate_btn') }}
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
    import ProjectCard from '@/Components/cards/ProjectCard.vue'

    const project = {
        "id": 3,
        "name": "Champlin, Weimann and Marquardt",
        "cif": "620331494",
        "logo": null,
        "description": "Quia enim aut possimus dignissimos consequatur iusto. Ea omnis laborum nihil voluptas fugiat. Corrupti molestiae tempore et placeat eius voluptatum nihil qui. Sed nobis quaerat et hic voluptates. Nemo quisquam qui facere odio ad aut vero. Dolorum esse voluptatibus in consequatur nostrum qui. Cum et rerum laborum perferendis nulla vitae. Rerum qui sint odio. Molestiae consequatur explicabo rerum quis. Sunt dolore ad neque corrupti rerum. Unde dolorum dolorem autem.",
        "status_document": null,
        "county_id": 20,
        "city_id": 88653,
        "street_address": "Shyanne Via",
        "contact_person": "Prof. Jeremy Murphy DDS",
        "contact_phone": "283-659-5054",
        "contact_email": "helene.ritchie@osinski.com",
        "website": "http://king.info/",
        "accepts_volunteers": 0,
        "why_volunteer": "Et recusandae dolor ipsum dolor vel aut. Hic vitae magni qui velit quo qui. Sint quaerat iusto iure autem blanditiis. Non repellendus eum rerum enim nobis earum accusantium.",
        "activity_domains": [
            "Securitate alimentară",
            "Sănătate",
            "Advocacy politici publice"
        ],
        "status": "active",
        "created_at": "2023-05-10T08:47:07.000000Z",
        "updated_at": "2023-05-10T08:47:07.000000Z",
        "deleted_at": null,
        "city_name": "Bretea Română",
        "county_name": "Hunedoara",
        "city": {
            "id": 88653,
            "county_id": 20,
            "level": 3,
            "type": 22,
            "parent_id": 88644,
            "name": "Bretea Română"
        },
        "county": {
            "id": 20,
            "siruta": 207,
            "name": "Hunedoara"
        }
    }

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
</script>
