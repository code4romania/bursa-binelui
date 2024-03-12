<template>
    <DashboardLayout>
        <!-- Inertia page head -->
        <Title :title="$t('regional.project.edit_page_title')" />

        <dl class="mt-6 border-t border-gray-100 divide-y divide-gray-100">
            <!-- Edit project name -->
            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.title')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.name"
                />
                <EditModal @action="editField('name')" class="flex justify-end col-span-1">
                    <!-- Project name -->
                    <Input
                        class="w-full"
                        :label="$t('regional.project.title')"
                        color="gray-700"
                        id="project-name"
                        type="text"
                        v-model="form.name"
                        :error="form.errors.name"
                    />
                </EditModal>
            </div>
            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.description')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.description"
                />
                <EditModal @action="editField('description')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional.project.description')"
                        color="gray-700"
                        id="amount-target"
                        type="number"
                        v-model="form.description"
                        :error="form.errors.description"
                    />
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.counties')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.counties?.map((item) => item.name).join(', ')"
                />
                <EditModal @action="editField('counties')" class="flex justify-end col-span-1">
                    <SelectMultiple
                        class="w-full xl:w-1/2"
                        :label="$t('regional.project.counties')"
                        :options="counties"
                        v-model="form.counties"
                        :error="form.errors.counties"
                    />
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.start_date')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.start_date"
                />
                <EditModal @action="editField('start_date')" class="flex justify-end col-span-1">
                    <div class="flex w-full gap-6">
                        <!-- Date start -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('start_date')"
                            color="gray-700"
                            type="date"
                            v-model="form.start_date"
                            :error="form.errors.start_date"
                        />
                    </div>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.end_date')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.end_date"
                />
                <EditModal @action="editField('end_date')" class="flex justify-end col-span-1">
                    <div class="flex w-full gap-6">
                        <!-- Date start -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('end_date')"
                            color="gray-700"
                            type="date"
                            v-model="form.end_date"
                            :error="form.errors.end_date"
                        />
                    </div>
                </EditModal>
            </div>

            <!-- Edit project category -->
            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.categories')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.categories?.map((item) => item.name).join(', ')"
                />
                <EditModal @action="editField('categories')" class="flex justify-end col-span-1">
                    <SelectMultiple
                        class="w-full"
                        :label="$t('project_category_label')"
                        :options="props.projectCategories"
                        v-model="form.categories"
                        :error="form.errors.categories"
                    />
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.youth')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.youth ? 'da' : 'nu'"
                />
                <EditModal @action="editField('youth')" class="flex justify-end col-span-1">
                    <Checkbox name="youth" v-model:checked="form.youth" />
                    <span class="ml-2 text-sm text-gray-700">{{ $t('regional.project.youth') }}</span>

                    <!-- Error -->
                    <p v-show="form.errors.youth" class="mt-2 text-sm text-red-600">
                        {{ form.errors.youth }}
                    </p>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.organization_type')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.organization_type"
                />
                <EditModal @action="editField('youth')" class="flex justify-end col-span-1">
                    <Radio
                        :label="$t('regional.project.organization_type')"
                        :options="organizationTypes"
                        name="locations"
                        v-model="form.organization_type"
                        :error="form.errors.organization_type"
                    />

                    <!-- Error -->
                    <p v-show="form.errors.organization_type" class="mt-2 text-sm text-red-600">
                        {{ form.errors.organization_type }}
                    </p>
                </EditModal>
            </div>

            <!-- Edit project scope -->
            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.identified_need')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.reason"
                />
                <EditModal @action="editField('reason')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional.project.identified_need')"
                        id="reason-project"
                        color="gray-700"
                        v-model="form.reason"
                        :error="form.errors.reason"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <!-- Edit project beneficiary -->
            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.proposed_solution')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.solution"
                />
                <EditModal @action="editField('solution')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional.project.proposed_solution')"
                        id="project-beneficiary"
                        color="gray-700"
                        v-model="form.solution"
                        :error="form.errors.solution"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.project_progress')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.project_details"
                />
                <EditModal @action="editField('project_details')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional.project.project_progress')"
                        id="project-beneficiary"
                        color="gray-700"
                        v-model="form.project_details"
                        :error="form.errors.project_details"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.what_is_special')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.special"
                />
                <EditModal @action="editField('special')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional.project.what_is_special')"
                        id="project-beneficiary"
                        color="gray-700"
                        v-model="form.special"
                        :error="form.errors.special"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.key_results')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.results"
                />
                <EditModal @action="editField('results')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional.project.key_results')"
                        id="project-beneficiary"
                        color="gray-700"
                        v-model="form.results"
                        :error="form.errors.results"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.pride_success')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.proud"
                />
                <EditModal @action="editField('proud')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional.project.pride_success')"
                        id="project-beneficiary"
                        color="gray-700"
                        v-model="form.proud"
                        :error="form.errors.proud"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.had_partners')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.partnership ? 'da' : 'nu'"
                />
                <EditModal @action="editField('partnership')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional.project.had_partners')"
                        id="project-beneficiary"
                        color="gray-700"
                        v-model="form.partnership"
                        :error="form.errors.partnership"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white" v-if="form.partnership">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.partners')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.partnership_details"
                />
                <EditModal @action="editField('partnership_details')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional.project.partners')"
                        id="project-beneficiary"
                        color="gray-700"
                        v-model="form.partnership_details"
                        :error="form.errors.partnership_details"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.project_budget')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.budget_details"
                />
                <EditModal @action="editField('budget_details')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional.project.project_budget')"
                        id="budget_details"
                        color="gray-700"
                        v-model="form.budget_details"
                        :error="form.errors.budget_details"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.participant_count_no')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.participants"
                />
                <EditModal @action="editField('participants')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional.project.participant_count_no')"
                        id="participants"
                        color="gray-700"
                        v-model="form.participants"
                        :error="form.errors.participants"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.project_team')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.team_details"
                />
                <EditModal @action="editField('team_details')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional.project.project_team')"
                        id="team_details"
                        color="gray-700"
                        v-model="form.team_details"
                        :error="form.errors.team_details"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.contact_info')"
                />
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    <div class="flex items center">
                        <div class="flex flex-col">
                            <span v-text="form.contact?.name" />
                            <span v-text="form.contact?.email" />
                            <span v-text="form.contact?.phone" />
                        </div>
                    </div>
                </dt>
                <EditModal @action="editField('team_details')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional.project.project_team')"
                        id="team_details"
                        color="gray-700"
                        v-model="form.team_details"
                        :error="form.errors.team_details"
                    >
                    </Textarea>
                </EditModal>
            </div>
        </dl>
    </DashboardLayout>
</template>

<script setup>
/** Import from inertia. */
import { Head, Link, useForm } from '@inertiajs/vue3';
import route from '@/Helpers/useRoute';

/** Import components. */
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

import EditModal from '@/Components/modals/EditModal.vue';
import Input from '@/Components/form/Input.vue';
import Textarea from '@/Components/form/Textarea.vue';
import FileGroup from '@/Components/form/FileGroup.vue';
import Repeater from '@/Components/form/Repeater.vue';
import InputWithIcon from '@/Components/form/InputWithIcon.vue';
import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
import { onMounted, ref } from 'vue';
import DangerButton from '@/Components/buttons/DangerButton.vue';
import SelectMultiple from '@/Components/form/SelectMultiple.vue';
import Checkbox from '@/Components/form/Checkbox.vue';
import Radio from '@/Components/form/Radio.vue';

const flash = {
    success_message: '',
    error_message: '',
};

const props = defineProps({
    project: Object,
    errors: Object,
    counties: Array,
    projectCategories: Array,
    success_message: String,
    error_message: String,
});

const impact_areas = [
    {
        label: 'Local',
        value: 'local',
    },
    {
        label: 'Judetean',
        value: 'judetean',
    },
    {
        label: 'Regional',
        value: 'regional',
    },
];

let project = ref(props.project);
let form = useForm(project.value);

onMounted(() => {
    console.log(props.project);
});

const editField = (field) => {
    let newForm = useForm({
        [field]: form[field],
    });
    newForm.post(route('dashboard.projects.regional.update', project.value.id));
};
</script>
