<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('add_project_title')"/>

        <!-- Dashboard template -->
        <Dashboard>
            <div class="w-full mb-24 p-9">

                <!-- Header -->
                <header class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                        <SvgLoader class="shrink-0 fill-primary-500" name="list"/>
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
                            :options="counties"
                            v-model="selectedCounties"
                            :error="form.errors.counties"
                        />

                        <!-- Date start_date -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('project_date_start_date_label')"
                            color="gray-700"
                            type="date"
                            v-model="form.start_date"
                            :error="form.errors.start_date"
                        />

                        <!-- Date end_date -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('project_date_end_date_label')"
                            color="gray-700"
                            type="date"
                            v-model="form.end_date"
                            :error="form.errors.end_date"
                        />

                        <!-- Project categories -->
                        <SelectMultiple
                            class="w-full xl:w-1/2"
                            :label="$t('project_categories_label')"
                            :options="projectCategories"
                            v-model="form.categories"
                            type="singleValue"
                            :error="form.errors.categories"
                        />

                        <label class="flex items-center">
                            <Checkbox
                                name="for_youth"
                                v-model:checked="form.for_youth"
                            />
                            <span class="ml-2 text-sm text-gray-700">{{ $t('regional_for_youth_label') }}</span>

                            <!-- Error -->
                            <p v-show="form.errors.for_youth" class="mt-2 text-sm text-red-600">
                                {{ form.errors.for_youth }}</p>
                        </label>

                        <!-- identified_need -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_identified_need_label')"
                            id="identified_need-project"
                            color="gray-700"
                            v-model="form.identified_need"
                            :error="form.errors.identified_need"
                        >
                        </Textarea>

                        <!-- proposed_solution -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_proposed_solution_label')"
                            id="proposed_solution-project"
                            color="gray-700"
                            v-model="form.proposed_solution"
                            :error="form.errors.proposed_solution"
                        >
                        </Textarea>

                        <!-- project_progress -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_project_progress_label')"
                            id="project_progress-project"
                            color="gray-700"
                            v-model="form.project_progress"
                            :error="form.errors.project_progress"
                        >
                        </Textarea>

                        <!-- Special about -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_what_is_special_label')"
                            id="special-project"
                            color="gray-700"
                            v-model="form.project_differentiator"
                            :error="form.errors.project_differentiator"
                        >
                        </Textarea>

                        <!-- key_results -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_key_results_label')"
                            id="key_results-project"
                            color="gray-700"
                            v-model="form.key_results"
                            :error="form.errors.key_results"
                        >
                        </Textarea>

                        <!-- pride_success -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_pride_success_label')"
                            id="pride_success-project"
                            color="gray-700"
                            v-model="form.pride_success"
                            :error="form.errors.pride_success"
                        >
                        </Textarea>

                        <!-- had_partners -->
                        <Radio
                            :label="$t('regional_had_partners_label')"
                            :options="[{'label': 'Da', 'value': 'yes'}, {'label': 'Nu', 'value': 'no'}]"
                            name="had_partners"
                            v-model="form.had_partners"
                            :error="form.errors.had_partners"
                        />

                        <!-- What parteners -->
                        <Textarea
                            v-if="'yes'===form.had_partners"
                            class="w-full"
                            :label="$t('regional_partners_label')"
                            id="what-parteners-project"
                            color="gray-700"
                            v-model="form.partners"
                            :error="form.errors.partners"
                        >
                        </Textarea>

                        <!-- project_budget -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_project_budget_label')"
                            id="project_budget-project"
                            color="gray-700"
                            v-model="form.project_budget"
                            :error="form.errors.project_budget"
                        >
                        </Textarea>
                        <p class="text-sm font-normal text-gray-500">{{ $t('regional_project_budget_summary') }}</p>

                        <!-- Arie -->
                        <Radio
                            :label="$t('regional_arie_label')"
                            :options="impact_areas"
                            name="locations"
                            v-model="form.impact_area"
                            :error="form.errors.impact_area"
                        />

                        <!-- participant_count -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_participant_count_no_label')"
                            id="participant_count-scope"
                            color="gray-700"
                            v-model="form.participant_count"
                            :error="form.errors.participant_count"
                        >
                        </Textarea>

                        <!-- project_team -->
                        <Textarea
                            class="w-full"
                            :label="$t('regional_project_team_label')"
                            id="project_team-scope"
                            color="gray-700"
                            v-model="form.project_team"
                            :error="form.errors.project_team"
                        >
                        </Textarea>

                        <hr class="bg-gray-500">

                        <Textarea
                            class="w-full"
                            :label="$t('regional_info_sources_label')"
                            id="extra-info"
                            color="gray-700"
                            v-model="form.info_sources"
                            :error="form.errors.info_sources"
                        >
                        </Textarea>

                        <div class="flex w-full" v-for="(item,index) in projectLinks">
                            <InputWithIcon
                                class="w-1/2"
                                :label="$t('regional_link_label')"
                                color="gray-700"
                                icon="https://"
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
                                background="primary-500"
                                hover="primary-400"
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

                        <!-- contact_info name -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('regional_contact_info_person')"
                            color="gray-700"
                            id="contact_info-name"
                            type="text"
                            v-model="form.contact_info.name"
                            :error="form?.errors?.contact_info?.name"
                        />

                        <!-- contact_info job -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('regional_contact_info_job')"
                            color="gray-700"
                            id="contact_info-job"
                            type="text"
                            v-model="form.contact_info.job"
                            :error="form?.errors?.contact_info?.job"
                        />

                        <!-- contact_info phone-->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('regional_contact_info_phone')"
                            color="gray-700"
                            id="project-name"
                            type="number"
                            v-model="form.contact_info.phone"
                            :error="form?.errors?.contact_info?.phone"
                        />


                        <!-- contact_info email -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('regional_contact_info_email')"
                            color="gray-700"
                            id="contact_info-email"
                            type="email"
                            v-model="form.contact_info.email"
                            :error="form?.errors?.contact_info?.email"
                        />

                        <hr class="bg-gray-500">

                        <div class="flex items-center justify-end_date gap-6">

                            <SecondaryButton class="py-2.5">
                                {{ $t('cancel') }}
                            </SecondaryButton>

                            <SecondaryButton
                                class="py-2.5"
                                @click="createProject('draft')"
                            >
                                {{ $t('preview') }}
                            </SecondaryButton>

                            <PrimaryButton
                                background="primary-500"
                                hover="primary-400"
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
    project_status: 'in_review',
    name: '',
    description: '',
    categories: [],
    start_date: '',
    end_date: '',
    counties: [],
    for_youth: false,
    identified_need: '',
    proposed_solution: '',
    project_progress: '',
    project_differentiator: '',
    key_results: '',
    pride_success: '',
    had_partners: '',
    partners: '',
    project_budget: '',
    impact_area: '',
    participant_count: '',
    project_team: '',
    info_sources: '',
    file_group: [],
    project_links: [{url: ''}],
    contact_info: {
        name: '',
        job: '',
        phone: '',
        email: ''
    }
});

let selectedCounties = [];
const props = defineProps(['projectCategories', 'counties']);
let projectLinks = ref(form.project_links);

const impact_areas = [
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
const createProject = (status='in_review') => {
    form.counties = selectedCounties.map(item => item.id);

    if(0 < form.categories.length) {
        form.categories = form.categories.map(item => item.id);
    }
    if (status==='draft')
    {
        form.project_status = 'draft';
    }

    prepareProjectLinks();
    form.post(route('admin.ong.regional.project.create'), {
        preserveScroll: true,
        onError: () => {},
    });
};
</script>
