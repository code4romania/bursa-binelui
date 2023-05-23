<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('projects_title')" />

        <!-- Alert -->
        <Alert
            class="fixed right-10 top-10 w-96 z-50"
            :type="flash.error_message ? 'error' : flash.success_message ? 'success' : false"
            :message="flash.success_message || flash.error_message"
            @emptyFlash="Object.assign(flash, { success_message:'', error_message:'' });"
        />

        <!-- Dashboard template -->
        <Dashboard>
           <div class="p-9 mb-24 ">

                <!-- Header -->
                <header class="flex items-center gap-4">
                    <div class="bg-turqoise-500 w-8 h-8 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0 fill-turqoise-500" name="list"/>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $t('published_projects') }}</h2>
                </header>

                <Link
                    :href="route('admin.ong.project.add', 1)"
                    class="inline-flex items-center justify-center gap-4 mt-9 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 py-2.5"
                >
                    <SvgLoader name="add" />
                    {{ $t('add_project') }}
                </Link>

                <!-- Published projects -->
                <PaginatedGrid
                    type="project"
                    cardType="admin"
                    :list="props.query"
                    classes="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
                />

                <!-- Draft projects -->
                <div class="flex items-center mt-20 gap-4">
                    <div class="bg-turqoise-500 w-8 h-8 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0 fill-turqoise-500" name="list"/>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $t('draft_projects') }}</h2>
                </div>

                <PaginatedGrid
                    type="project"
                    cardType="admin"
                    :list="props.query"
                    classes="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
                />
           </div>
        </Dashboard>
    </PageLayout>
</template>

<script setup>
    /** Remove this import after backend connection. */
    import projects from '@/local_json/projects.js';

    /** Import from inertia. */
    import { Head, Link } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Dashboard from '@/Components/templates/Dashboard.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import PaginatedGrid from '@/Components/templates/PaginatedGrid.vue';
    import Alert from '@/Components/Alert.vue';
    import {onMounted} from "vue";

    const flash = {
        success_message:'',
        error_message:''
    };
    const  props =defineProps({
        query: {
            type: Object,
        }
    });

    // const props = {
    //     "activity_domains": [
    //         "Protecția mediului",
    //         "Educație",
    //         "Sănătate",
    //         "Drepturile omului",
    //         "Dezvoltare rurală",
    //         "Sprijin dizabilități",
    //         "Egalitate de gen",
    //         "Reducerea sărăciei",
    //         "Integrarea minorităților",
    //         "Sprijin tineret",
    //         "Asistență vârstnici",
    //         "Patrimoniu cultural",
    //         "Artă și cultură",
    //         "Sport și recreere",
    //         "Dezvoltare comunitară",
    //         "Prevenire violență domestică",
    //         "Ajutor imigranți/refugiați",
    //         "Combatere trafic uman",
    //         "Bună guvernare",
    //         "Protecția animalelor",
    //         "Prevenire dependență droguri",
    //         "Advocacy politici publice",
    //         "Anti-discriminare",
    //         "Îmbunătățire infrastructură",
    //         "Antreprenoriat social",
    //         "Gestionare dezastre",
    //         "Drepturile consumatorilor",
    //         "Sprijin familie",
    //         "Promovare voluntariat",
    //         "Asistență juridică",
    //         "Protecția vieții private",
    //         "Combatere corupție",
    //         "Sănătate mintală",
    //         "Drepturile animalelor",
    //         "Cercetare științifică",
    //         "Dezvoltare durabilă",
    //         "Securitate alimentară",
    //         "Control boli infecțioase",
    //         "Sprijin veterani",
    //         "Dezvoltare regională/internațională"
    //     ],
    //     "cities": [
    //     {
    //         "id": 88653,
    //         "name": "Bretea Română, Hunedoara"
    //     },
    //     {
    //         "id": 117248,
    //         "name": "Periș, Mureș"
    //     },
    //     {
    //         "id": 65057,
    //         "name": "Zăbala, Covasna"
    //     },
    //     {
    //         "id": 76335,
    //         "name": "Ijdileni, Galați"
    //     },
    //     {
    //         "id": 68002,
    //         "name": "Mănești, Dâmbovița"
    //     },
    //     {
    //         "id": 87665,
    //         "name": "Oraș Simeria, Hunedoara"
    //     },
    //     {
    //         "id": 110964,
    //         "name": "Crivina, Mehedinți"
    //     },
    //     {
    //         "id": 95836,
    //         "name": "Mădârjești, Iași"
    //     },
    //     {
    //         "id": 70478,
    //         "name": "Răcarii De Sus, Dolj"
    //     },
    //     {
    //         "id": 21793,
    //         "name": "Florești, Bacău"
    //     },
    //     {
    //         "id": 160555,
    //         "name": "Florești, Tulcea"
    //     },
    //     {
    //         "id": 27855,
    //         "name": "Budureasa, Bihor"
    //     },
    //     {
    //         "id": 138191,
    //         "name": "Micula Nouă, Satu Mare"
    //     },
    //     {
    //         "id": 141731,
    //         "name": "Ip, Sălaj"
    //     },
    //     {
    //         "id": 47710,
    //         "name": "Plavățu, Buzău"
    //     },
    //     {
    //         "id": 9351,
    //         "name": "Sânleani, Arad"
    //     },
    //     {
    //         "id": 38134,
    //         "name": "Cucorăni, Botoșani"
    //     },
    //     {
    //         "id": 91624,
    //         "name": "Totești, Hunedoara"
    //     },
    //     {
    //         "id": 168586,
    //         "name": "Bârzești, Vâlcea"
    //     },
    //     {
    //         "id": 113126,
    //         "name": "Răiculești, Mehedinți"
    //     }
    //     ],
    //     "query": {
    //     "current_page": 1,
    //     "data": projects,
    //     "first_page_url": "http://bursabinelui.test/proiecte?page=1",
    //     "from": 1,
    //     "last_page": 2,
    //     "last_page_url": "http://bursabinelui.test/proiecte?page=2",
    //     "links": [
    //         {
    //         "url": "http://bursabinelui.test/proiecte?page=1",
    //         "label": "1",
    //         "active": true
    //         },
    //         {
    //         "url": "http://bursabinelui.test/proiecte?page=2",
    //         "label": "2",
    //         "active": false
    //         }
    //     ],
    //     "next_page_url": "http://bursabinelui.test/proiecte?page=2",
    //     "path": "http://bursabinelui.test/proiecte",
    //     "per_page": 15,
    //     "prev_page_url": null,
    //     "to": 15,
    //     "total": 20
    //     }
    // }
</script>
