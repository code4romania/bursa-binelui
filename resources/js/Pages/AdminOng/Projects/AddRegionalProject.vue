<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('add_project_title')"/>

        <!-- Dashboard template -->
        <Dashboard>
            <div class="w-full mb-24 p-9">

                <!-- Header -->
                <header class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-turqoise-500">
                        <SvgLoader class="shrink-0 fill-turqoise-500" name="list"/>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $t('add_project_title') }}</h2>
                </header>

                <form @submit.prevent="createProject">
                    <div class="w-full space-y-6 max-w-7xl mt-9">
                        <!-- Project name -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('project_name_label')"
                            color="gray-700"
                            id="project-name"
                            type="text"
                            v-model="form.name"
                            :error="form.errors.name"
                        />

                        <!-- Project description -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_description_label')"
                            id="about-project"
                            color="gray-700"
                            v-model="form.description"
                            :error="form.errors.description"
                        >
                        </Textarea>
                        <p class="text-sm font-normal text-gray-500">{{ $t('regional_description_summary') }}</p>

                         <!-- County -->
                         <SelectMultiple
                            class="w-full xl:w-1/2"
                            :label="$t('counties_label')"
                            :options="countries"
                            v-model="selectedCounties"
                            :error="form.errors.counties"
                        />

                        <!-- Date start -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('project_date_start_label')"
                            color="gray-700"
                            type="date"
                            v-model="form.start"
                            :error="form.errors.start"
                        />

                        <!-- Date end -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('project_date_end_label')"
                            color="gray-700"
                            type="date"
                            v-model="form.end"
                            :error="form.errors.end"
                        />

                        <!-- Project category -->
                        <Select
                            class="w-full xl:w-1/2"
                            :label="$t('project_category_label')"
                            :options="projectCategories"
                            v-model="form.category"
                            :error="form.errors.category"
                        />

                        <label class="flex items-center">
                            <Checkbox
                                name="addressed"
                                v-model:checked="form.addressed"
                            />
                            <span class="ml-2 text-sm text-gray-700">{{ $t('regional_addressed_label') }}</span>

                            <!-- Error -->
                            <p v-show="form.errors.addressed" class="mt-2 text-sm text-red-600">
                                {{ form.errors.addressed }}</p>
                        </label>

                        <!-- Needs -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_needs_label')"
                            id="needs-project"
                            color="gray-700"
                            v-model="form.needs"
                            :error="form.errors.needs"
                        >
                        </Textarea>

                        <!-- Solution -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_solution_label')"
                            id="solution-project"
                            color="gray-700"
                            v-model="form.solution"
                            :error="form.errors.solution"
                        >
                        </Textarea>

                        <!-- Stats -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_project_stats_label')"
                            id="stats-project"
                            color="gray-700"
                            v-model="form.stats"
                            :error="form.errors.stats"
                        >
                        </Textarea>

                        <!-- Special about -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_what_is_special_label')"
                            id="special-project"
                            color="gray-700"
                            v-model="form.special_about"
                            :error="form.errors.special_about"
                        >
                        </Textarea>

                        <!-- Results -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_results_label')"
                            id="results-project"
                            color="gray-700"
                            v-model="form.results"
                            :error="form.errors.results"
                        >
                        </Textarea>

                        <!-- Proud -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_proud_label')"
                            id="proud-project"
                            color="gray-700"
                            v-model="form.proud"
                            :error="form.errors.proud"
                        >
                        </Textarea>

                        <!-- Parteners -->
                        <Radio
                            :label="$t('regional_parteners_label')"
                            :options="[{'label': 'Da', 'value': 'yes'}, {'label': 'Nu', 'value': 'no'}]"
                            v-model="form.parteners"
                            :error="form.errors.parteners"
                        />

                        <!-- What parteners -->
                        <Textarea
                            v-if="'yes'==form.parteners"
                            class="w-full"
                            :label="$t('regional_what_parteners_label')"
                            id="what-parteners-project"
                            color="gray-700"
                            v-model="form.what_parteners"
                            :error="form.errors.what_parteners"
                        >
                        </Textarea>

                        <!-- Budget -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_budget_label')"
                            id="budget-project"
                            color="gray-700"
                            v-model="form.budget"
                            :error="form.errors.budget"
                        >
                        </Textarea>
                        <p class="text-sm font-normal text-gray-500">{{ $t('regional_budget_summary') }}</p>

                        <!-- Arie -->
                        <Radio
                            :label="$t('regional_arie_label')"
                            :options="arias"
                            v-model="form.aria"
                            :error="form.errors.aria"
                        />

                        <!-- Participants -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_participants_no_label')"
                            id="participants-scope"
                            color="gray-700"
                            v-model="form.participants"
                            :error="form.errors.participants"
                        >
                        </Textarea>

                        <!-- Organization -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_organization_label')"
                            id="organization-scope"
                            color="gray-700"
                            v-model="form.organization"
                            :error="form.errors.organization"
                        >
                        </Textarea>

                        <hr class="bg-gray-500">

                        <Textarea
                            class="w-full"
                            :label="$t('regional_extra_info_label')"
                            id="extra-info"
                            color="gray-700"
                            v-model="form.extra_info"
                            :error="form.errors.extra_info"
                        >
                        </Textarea>

                        <div class="flex w-full" v-for="(item,index) in projectLinks">
                            <InputWithIcon
                                class="w-1/2"
                                :label="$t('regional_link_label')"
                                color="gray-700"
                                icon="htpp://"
                                type="text"
                                v-model="item.url"
                            />
                            <DangerButton
                                v-if="index > 0"
                                class="mt-8 ml-4"
                                background="red-500"
                                hover="red-400"
                                color="white"
                                @click="()=>{projectLinks.pop()}">
                                {{ $t('remove')}}
                            </DangerButton>
                            <SecondaryButton
                                v-if="projectLinks.length <= 5"
                                class="mt-8 ml-4"
                                background="turqoise-500"
                                hover="turqoise-400"
                                color="white"
                                @click="()=>{projectLinks.push({url:''})}">
                                {{ $t('add') }}
                            </SecondaryButton>

                        </div>

                        <!-- File group -->
                        <FileGroup
                            v-model="form.file_group"
                        />

                        <hr class="bg-gray-500">

                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Persoana de contact</h2>
                            <p class="text-gray-500">Organizația poate recruta voluntari prin platforma Bursa Binelui. Completează datele de mai jos dacă dorești acest lucru pentru organizația ta.</p>
                        </div>

                        <!-- Contact name -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('regional_contact_person')"
                            color="gray-700"
                            id="contact-name"
                            type="text"
                            v-model="form.contact.name"
                            :error="form?.errors?.contact?.name"
                        />

                        <!-- Contact job -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('regional_contact_job')"
                            color="gray-700"
                            id="contact-job"
                            type="text"
                            v-model="form.contact.job"
                            :error="form?.errors?.contact?.job"
                        />

                        <!-- Contact phone-->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('regional_contact_phone')"
                            color="gray-700"
                            id="project-name"
                            type="number"
                            v-model="form.contact.phone"
                            :error="form?.errors?.contact?.phone"
                        />


                        <!-- Contact email -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('regional_contact_email')"
                            color="gray-700"
                            id="contact-email"
                            type="email"
                            v-model="form.contact.email"
                            :error="form?.errors?.contact?.email"
                        />

                        <hr class="bg-gray-500">

                        <div class="flex items-center justify-end gap-6">

                            <SecondaryButton class="py-2.5">
                                {{ $t('cancel') }}
                            </SecondaryButton>

                            <SecondaryButton class="py-2.5">
                                {{ $t('preview') }}
                            </SecondaryButton>

                            <PrimaryButton
                                background="turqoise-500"
                                hover="turqoise-400"
                                color="white"
                                @click="createProject"
                            >
                                {{ $t('save') }}
                            </PrimaryButton>

                        </div>
                    </div>
                </form>
            </div>
        </Dashboard>
    </PageLayout>
</template>

<script setup>
import {ref} from "vue";

/** Import from inertia. */
import {Head, useForm} from '@inertiajs/vue3';

/** Import components. */
import PageLayout from '@/Layouts/PageLayout.vue';
import Dashboard from '@/Components/templates/Dashboard.vue';
import SvgLoader from '@/Components/SvgLoader.vue';
import Input from '@/Components/form/Input.vue';
import Select from '@/Components/form/Select.vue';
import Textarea from '@/Components/form/Textarea.vue';
import Checkbox from '@/Components/form/Checkbox.vue';
import FileGroup from '@/Components/form/FileGroup.vue';
import InputWithIcon from '@/Components/form/InputWithIcon.vue';
import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
import DangerButton from "@/Components/buttons/DangerButton.vue";
import SelectMultiple from "@/Components/form/SelectMultiple.vue";
import Radio from '@/Components/form/Radio.vue';

/** Initialize inertia from Object. */
const form = useForm({
    name: '',
    description: '',
    category: '',
    start: '',
    end: '',
    counties: [],
    addressed: false,
    needs: '',
    solution: '',
    stats: '',
    special_about: '',
    results: '',
    proud: '',
    parteners: '',
    what_parteners: '',
    budget: '',
    aria: '',
    participants: '',
    organization: '',
    extra_info: '',
    file_group: [],
    project_links: [{url: ''}],
    contact: {
        name: '',
        job: '',
        phone: '',
        email: ''
    }
});
let selectedCounties = [];
const props = defineProps(['projectCategories', 'countries']);
let projectLinks = ref(form.project_links);

const arias = [
    {
        'label': 'Local',
        'value': 'local'
    },
    {
        'label': 'Judetean',
        'value': 'judetean'
    },
    {
        'label': 'Regional',
        'value': 'regional'
    }
];

function prepareProjectLinks() {
    form.project_links = projectLinks.value.filter(item => item.url !== '').map(item => item.url);
}

/** Create project. */
const createProject = () => {
    form.counties = selectedCounties.map(item => item.id);
    prepareProjectLinks();
    form.post(route('admin.ong.project.storeRegional'), {
        preserveScroll: true,
        onError: () => {
        },
    });
};
</script>
