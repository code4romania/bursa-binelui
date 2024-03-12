<template>
    <DashboardLayout>
        <!-- Inertia page head -->
        <Title :title="$t('regional.project.page_title') + galaTitle" />

        <form @submit.prevent="createProject">
            <div class="w-full space-y-6 max-w-7xl mt-9">
                <!-- Project name -->
                <Input
                    class="w-full xl:w-1/2"
                    :label="$t('regional.project.title')"
                    color="gray-700"
                    id="project-name"
                    type="text"
                    v-model="form.name"
                    :error="form.errors.name"
                />

                <!-- Project description -->
                <Textarea
                    class="w-full"
                    :label="$t('regional.project.description')"
                    id="about-project"
                    color="gray-700"
                    :more-info="$t('regional.project.description_info')"
                    :number-of-characters="700"
                    v-model="form.description"
                    :error="form.errors.description"
                >
                </Textarea>

                <!-- County -->
                <SelectMultiple
                    class="w-full xl:w-1/2"
                    :label="$t('regional.project.counties')"
                    :options="counties"
                    v-model="selectedCounties"
                    :error="form.errors.counties"
                />

                <div class="grid grid-cols-2">
                    <Input
                        class="w-full xl:w-1/2"
                        :label="$t('regional.project.start_date')"
                        color="gray-700"
                        type="date"
                        v-model="form.start_date"
                        :error="form.errors.start_date"
                    />

                    <!-- Date end_date -->
                    <Input
                        class="w-full xl:w-1/2"
                        :label="$t('regional.project.end_date')"
                        color="gray-700"
                        type="date"
                        v-model="form.end_date"
                        :error="form.errors.end_date"
                    />
                </div>

                <!-- Project categories -->
                <SelectMultiple
                    class="w-full xl:w-1/2"
                    :label="$t('regional.project.categories')"
                    :options="projectCategories"
                    v-model="form.categories"
                    type="singleValue"
                    :error="form.errors.categories"
                />

                <label class="flex items-center">
                    <Checkbox name="youth" v-model:checked="form.youth" />
                    <span class="ml-2 text-sm text-gray-700">{{ $t('regional.project.youth') }}</span>
                </label>

                <Radio
                    :label="$t('regional.project.organization_type')"
                    :options="organizationTypes"
                    name="locations"
                    v-model="form.organization_type"
                    :error="form.errors.organization_type"
                />

                <Textarea
                    class="w-full"
                    :label="$t('regional.project.identified_need')"
                    id="identified_need-project"
                    color="gray-700"
                    v-model="form.reason"
                    :error="form.errors.reason"
                >
                </Textarea>

                <Textarea
                    class="w-full"
                    :label="$t('regional.project.proposed_solution')"
                    id="proposed_solution-project"
                    color="gray-700"
                    v-model="form.solution"
                    :error="form.errors.solution"
                >
                </Textarea>

                <Textarea
                    class="w-full"
                    :label="$t('regional.project.project_progress')"
                    id="project_progress-project"
                    color="gray-700"
                    v-model="form.project_details"
                    :error="form.errors.project_details"
                >
                </Textarea>

                <!-- Special about -->
                <Textarea
                    class="w-full"
                    :label="$t('regional.project.what_is_special')"
                    id="special-project"
                    color="gray-700"
                    v-model="form.special"
                    :error="form.errors.special"
                >
                </Textarea>

                <Textarea
                    class="w-full"
                    :label="$t('regional.project.key_results')"
                    id="key_results-project"
                    color="gray-700"
                    v-model="form.results"
                    :error="form.errors.results"
                >
                </Textarea>

                <Textarea
                    class="w-full"
                    :label="$t('regional.project.pride_success')"
                    id="pride_success-project"
                    color="gray-700"
                    v-model="form.proud"
                    :error="form.errors.proud"
                >
                </Textarea>

                <Radio
                    :label="$t('regional.project.had_partners')"
                    :options="[
                        { label: 'Da', value: true },
                        { label: 'Nu', value: false },
                    ]"
                    name="had_partners"
                    v-model="form.partnership"
                    :error="form.errors.partnership"
                />

                <Textarea
                    v-if="form.partnership"
                    class="w-full"
                    :label="$t('regional.project.partners')"
                    id="what-partners-project"
                    color="gray-700"
                    v-model="form.partnership_details"
                    :error="form.errors.partnership_details"
                >
                </Textarea>

                <Textarea
                    class="w-full"
                    :label="$t('regional.project.project_budget')"
                    id="project_budget-project"
                    color="gray-700"
                    v-model="form.budget_details"
                    :error="form.errors.budget_details"
                >
                </Textarea>

                <!-- Arie -->
                <Radio
                    :label="$t('regional.project.arie')"
                    :options="areas"
                    name="locations"
                    v-model="form.area"
                    :error="form.errors.area"
                />

                <!-- participant_count -->
                <Textarea
                    class="w-full"
                    :label="$t('regional.project.participant_count_no')"
                    id="participant_count-scope"
                    color="gray-700"
                    v-model="form.participants"
                    :error="form.errors.participants"
                >
                </Textarea>

                <!-- project_team -->
                <Textarea
                    class="w-full"
                    :label="$t('regional.project.project_team')"
                    id="project_team-scope"
                    color="gray-700"
                    v-model="form.team_details"
                    :error="form.errors.team_details"
                >
                </Textarea>

                <!-- File group -->
                <FileGroup v-model="form.file_group" />

                <hr class="bg-gray-500" />

                <div>
                    <h2 class="text-lg font-bold text-gray-900" v-text="$t('regional.project.contact_info')" />
                    <p class="text-gray-500" v-text="$t('regional.project.contact_info_details')" />
                </div>

                <!-- contact_info name -->
                <Input
                    class="w-full xl:w-1/2"
                    :label="$t('regional.project.contact_info_person')"
                    color="gray-700"
                    id="contact_info-name"
                    type="text"
                    v-model="form.contact.name"
                    :error="form?.errors?.contact?.name"
                />

                <!-- contact_info job -->
                <Input
                    class="w-full xl:w-1/2"
                    :label="$t('regional.project.contact_info_job')"
                    color="gray-700"
                    id="contact_info-job"
                    type="text"
                    v-model="form.contact.job"
                    :error="form?.errors?.contact?.job"
                />

                <!-- contact_info phone-->
                <Input
                    class="w-full xl:w-1/2"
                    :label="$t('regional.project.contact_info_phone')"
                    color="gray-700"
                    id="project-name"
                    type="number"
                    v-model="form.contact.phone"
                    :error="form?.errors?.contact?.phone"
                />

                <!-- contact_info email -->
                <Input
                    class="w-full xl:w-1/2"
                    :label="$t('regional.project.contact_info_email')"
                    color="gray-700"
                    id="contact_info-email"
                    type="email"
                    v-model="form.contact.email"
                    :error="form?.errors?.contact?.email"
                />

                <h2 class="text-lg font-bold text-gray-900" v-text="$t('regional.project.info_by_email')" />
                <label class="flex items-center">
                    <Checkbox name="info_by_email" v-model:checked="form.info_by_email" />
                    <span class="ml-2 text-sm text-gray-700">{{ $t('regional.project.info_by_email_info') }}</span>
                </label>

                <hr class="bg-gray-500" />

                <div class="flex items-center gap-6 justify-end_date">
                    <SecondaryButton class="py-2.5">
                        {{ $t('cancel') }}
                    </SecondaryButton>

                    <SecondaryButton class="py-2.5" @click="createProject('draft')">
                        {{ $t('preview') }}
                    </SecondaryButton>

                    <PrimaryButton @click="createProject" :label="$t('save')" />
                </div>
            </div>
        </form>
    </DashboardLayout>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import route from '@/Helpers/useRoute';

/** Import from inertia. */
import { useForm } from '@inertiajs/vue3';

/** Import components. */
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Title from '@/Components/Title.vue';
import Input from '@/Components/form/Input.vue';
import Textarea from '@/Components/form/Textarea.vue';
import Checkbox from '@/Components/form/Checkbox.vue';
import FileGroup from '@/Components/form/FileGroup.vue';
import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
import SelectMultiple from '@/Components/form/SelectMultiple.vue';
import Radio from '@/Components/form/Radio.vue';

/** Initialize inertia from Object. */
const form = useForm({
    gala_id: '',
    project_status: 'pending',
    name: '',
    description: '',
    categories: [],
    organization_type: '',
    start_date: '',
    end_date: '',
    counties: [],
    youth: false,
    reason: '',
    solution: '',
    project_details: '',
    special: '',
    results: '',
    proud: '',
    partnership: '',
    partnership_details: '',
    budget_details: '',
    area: '',
    participants: '',
    team_details: '',
    file_group: [],
    info_by_email: false,
    contact: {
        name: '',
        job: '',
        phone: '',
        email: '',
    },
});

let selectedCounties = [];
const props = defineProps(['projectCategories', 'counties', 'galaTitle', 'areas', 'galaId', 'organizationTypes']);

onMounted(() => {
    console.log(props.areas);
});

/** Create project. */
const createProject = (status = 'in_review') => {
    form.gala_id = props.galaId;
    form.post(route('dashboard.projects.regional.store'), {
        preserveScroll: true,
        onError: () => {},
    });
};
</script>
