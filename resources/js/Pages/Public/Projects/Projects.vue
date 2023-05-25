<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('projects_title')" />

        <div class="p-9 mx-auto max-w-7xl mt-4 mb-24">

            <!-- Header -->
            <header class="flex items-center gap-4">
                <div class="bg-turqoise-500 w-8 h-8 rounded-lg flex items-center justify-center">
                    <SvgLoader class="shrink-0 fill-turqoise-500" name="list"/>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $t('projects_title') }}</h2>
            </header>

            <!-- Filters -->
            <div class="my-11">
                <div class="flex flex-col sm:flex-row w-full">
                    <div class="w-full flex-col sm:flex-row xl:w-8/12 flex items-center gap-6">

                        <!-- Search -->
                        <div class="flex gap-6">
                            <SearchFilter
                                id="project-search"
                                class="w-full"
                                v-model="filter.s"
                                color="gray-700"
                                :placeholder="$t('search')"
                                @keydown.enter="filterProjects"
                            />

                            <!-- Search action -->
                            <SecondaryButton
                                @click="filterProjects"
                                class="py-2"
                            >
                                {{ $t('search') }}
                            </SecondaryButton>
                        </div>

                        <div class="flex gap-6 w-full mb-6 sm:mb-0">
                            <!-- Empty filters. -->
                            <SecondaryButton
                                v-if="hasValues"
                                @click="emptyFilters"
                                class="py-2 flex gap-2 items-center w-1/2 sm:w-auto"
                            >
                                <SvgLoader name="close" />
                                {{ $t('empty_filters') }}
                            </SecondaryButton>


                            <!-- Sort -->
                            <Sort class="w-1/2 sm:w-auto" />
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="xl:w-4/12 flex flex-col sm:flex-row justify-end gap-6">
                        <Link
                            :href="route('projects')"
                            class="flex items-center gap-x-4 bg-turqoise-500 hover:bg-turqoise-400 text-white rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm"
                        >
                            <SvgLoader class="shrink-0" name="grid"/>
                            {{ $t('projects_list') }}
                        </Link>

                        <Link
                            :href="route('projects')"
                            class="flex items-center gap-x-4 rounded-md bg-white px-3.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 py-2.5"
                        >
                            <SvgLoader class="shrink-0" name="location"/>
                            {{ $t('projects_map') }}
                        </Link>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row w-full justify-between gap-6 mt-6">

                    <Select
                        class="w-full"
                        :label="$t('status')"
                        v-model="filter.status"
                        :options="statuses"
                    />

                    <MultiSelectObjectFilter
                        class="w-full"
                        :label="$t('county_city')"
                        v-model="filter.c"
                        :options="props.counties"
                        @callback="filterProjects"
                    />

                    <!-- Date -->
                    <Input
                        class="w-full"
                        :label="$t('period')"
                        color="gray-700"
                        id="project-name"
                        type="date"
                        v-model="filter.period"
                    />
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-900">{{ props.query.total }} {{ $t('of_projects') }}</h2>

            <!-- Published projects -->
            <PaginatedGrid
                type="project"
                cardType="client"
                :list="props.query"
                classes="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 mb-4"
            />
        </div>
    </PageLayout>
</template>

<script setup>
    /** Remove this import after backend connection. */
    import projects from '@/local_json/projects.js';

    /** Import from vue. */
    import { ref } from 'vue';

    /** Import from inertia. */
    import { Head, Link, router } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Sort from '@/Components/filters/Sort.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Input from '@/Components/form/Input.vue';
    import Select from '@/Components/form/Select.vue';
    import SearchFilter from '@/Components/filters/SearchFilter.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import PaginatedGrid from '@/Components/templates/PaginatedGrid.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import MultiSelectObjectFilter from '@/Components/filters/MultiSelectObjectFilter.vue';

    /** Active filter state. */
    const hasValues = ref(false);

    /** Filter values. */
    const filter = ref({
        ad: '',
        c: '',
        s: '',
        status:'',
        period: ''
    });

    /** Statuses */
    const statuses = ['Active', 'Inactive'];
    const cities = [{}];

    /** Filter projects. */
    const filterProjects = () => {
        if (Object.values(filter.value).every(value => value === null)) {
            hasValues.value = false
        } else {
            hasValues.value = true
        }
    };

    /** Empty filters. */
    const emptyFilters = () => {
        router.visit(route('projects'))
    };
    const  props =defineProps({
        query: {
            type: Object,
        },
        counties: {
            type: Array,
        },
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
