<template>
    <DashboardLayout>
        <!-- Inertia page head -->
        <Title :title="$t('edit_project_title')" />

        <dl class="mt-6 border-t border-gray-100 divide-y divide-gray-100">
            <!-- Edit project name -->
            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('project_name_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.name }}
                </dt>
                <EditModal @action="editField('name')" class="flex justify-end col-span-1">
                    <!-- Project name -->
                    <Input
                        class="w-full"
                        :label="$t('project_name_label')"
                        color="gray-700"
                        id="project-name"
                        type="text"
                        v-model="form.name"
                        :error="form.errors.name"
                    />
                </EditModal>
            </div>

            <!-- Edit target amount -->
            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_description_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.description }}
                </dt>
                <EditModal @action="editField('description')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional_description_label')"
                        color="gray-700"
                        id="amount-target"
                        type="number"
                        v-model="form.description"
                        :error="form.errors.description"
                    />
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('counties_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.counties?.map((item) => item.name).join(', ') }}
                </dt>
                <EditModal @action="editField('counties')" class="flex justify-end col-span-1">
                    <SelectMultiple
                        class="w-full xl:w-1/2"
                        :label="$t('counties_label')"
                        :options="counties"
                        v-model="form.counties"
                        :error="form.errors.counties"
                    />
                </EditModal>
            </div>

            <!-- Edit period -->
            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_period') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.start_date }} - {{ form.end_date }}
                </dt>
                <EditModal @action="editField('start', 'end')" class="flex justify-end col-span-1">
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

                        <!-- Date end -->
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
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('project_category_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.categories?.map((item) => item.name).join(', ') }}
                </dt>
                <EditModal @action="editField('category')" class="flex justify-end col-span-1">
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
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_for_youth_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.for_youth ? 'da' : 'nu' }}
                </dt>
                <EditModal @action="editField('for_youth')" class="flex justify-end col-span-1">
                    <Checkbox name="for_youth" v-model:checked="form.for_youth" />
                    <span class="ml-2 text-sm text-gray-700">{{ $t('regional_for_youth_label') }}</span>

                    <!-- Error -->
                    <p v-show="form.errors.for_youth" class="mt-2 text-sm text-red-600">
                        {{ form.errors.for_youth }}
                    </p>
                </EditModal>
            </div>

            <!-- Edit project scope -->
            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_identified_need_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.identified_need }}
                </dt>
                <EditModal @action="editField('identified_need')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional_identified_need_label')"
                        id="identified_need-project"
                        color="gray-700"
                        v-model="form.identified_need"
                        :error="form.errors.identified_need"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <!-- Edit project beneficiary -->
            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_proposed_solution_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.proposed_solution }}
                </dt>
                <EditModal @action="editField('proposed_solution')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional_proposed_solution_label')"
                        id="project-beneficiary"
                        color="gray-700"
                        v-model="form.proposed_solution"
                        :error="form.errors.proposed_solution"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_project_progress_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.project_progress }}
                </dt>
                <EditModal @action="editField('project_progress')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional_project_progress_label')"
                        id="why-to-donate"
                        color="gray-700"
                        v-model="form.project_progress"
                        :error="form.errors.project_progress"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_what_is_special_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.project_differentiator }}
                </dt>
                <EditModal @action="editField('project_differentiator')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional_what_is_special_label')"
                        id="why-to-donate"
                        color="gray-700"
                        v-model="form.project_differentiator"
                        :error="form.errors.project_differentiator"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_key_results_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.key_results }}
                </dt>
                <EditModal @action="editField('key_results')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional_key_results_label')"
                        id="why-to-donate"
                        color="gray-700"
                        v-model="form.key_results"
                        :error="form.errors.key_results"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_pride_success_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.pride_success }}
                </dt>
                <EditModal @action="editField('pride_success')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional_pride_success_label')"
                        id="why-to-donate"
                        color="gray-700"
                        v-model="form.pride_success"
                        :error="form.errors.pride_success"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_had_partners_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.had_partners ? 'Da' : 'Nu' }}
                </dt>
                <EditModal @action="editField('had_partners')" class="flex justify-end col-span-1">
                    <Radio
                        :label="$t('regional_had_partners_label')"
                        :options="[
                            { label: 'Da', value: true },
                            { label: 'Nu', value: false },
                        ]"
                        name="had_partners"
                        v-model="form.had_partners"
                        :error="form.errors.had_partners"
                    />
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100" v-if="form.had_partners">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_partners_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.partners }}
                </dt>
                <EditModal @action="editField('partners')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional_had_partners_label')"
                        id="why-to-donate"
                        color="gray-700"
                        v-model="form.partners"
                        :error="form.errors.partners"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_project_budget_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.project_budget }}
                </dt>
                <EditModal @action="editField('project_budget')" class="flex justify-end col-span-1">
                    <Textarea
                        class="w-full"
                        :label="$t('regional_project_budget_label')"
                        id="why-to-donate"
                        color="gray-700"
                        v-model="form.project_budget"
                        :error="form.errors.project_budget"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_arie_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.impact_area }}
                </dt>
                <EditModal @action="editField('impact_area')" class="flex justify-end col-span-1">
                    <Radio
                        :label="$t('regional_arie_label')"
                        :options="impact_areas"
                        name="locations"
                        v-model="form.impact_area"
                        :error="form.errors.impact_area"
                    />
                </EditModal>
            </div>
            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_participant_count_no_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.participant_count }}
                </dt>
                <EditModal @action="editField('participant_count')" class="flex justify-end col-span-1">
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
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_project_team_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.project_team }}
                </dt>
                <EditModal @action="editField('project_team')" class="flex justify-end col-span-1">
                    <!-- participant_count -->
                    <Textarea
                        class="w-full"
                        :label="$t('regional_project_team_label')"
                        id="participant_count-scope"
                        color="gray-700"
                        v-model="form.project_team"
                        :error="form.errors.project_team"
                    >
                    </Textarea>
                </EditModal>
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('regional_info_sources_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ form.info_sources }}
                </dt>
                <EditModal @action="editField('info_sources')" class="flex justify-end col-span-1">
                    <!-- participant_count -->
                    <Textarea
                        class="w-full"
                        :label="$t('regional_info_sources_label')"
                        id="extra-info"
                        color="gray-700"
                        v-model="form.info_sources"
                        :error="form.errors.info_sources"
                    >
                    </Textarea>
                </EditModal>
            </div>
        </dl>

        <div class="flex items-center gap-4 mt-9">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                <!-- <SvgLoader class="shrink-0 fill-primary-500" name="book" /> -->
            </div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $t('external_links_title') }}</h2>
        </div>

        <EditModal @action="editField()" btnClasses="" class="mt-9">
            <InputWithIcon
                class="w-full"
                :label="$t('articles_link_label')"
                color="gray-700"
                icon="https://"
                type="text"
                v-model="form.project_articles"
            />
        </EditModal>

        <div class="mt-6 border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
                <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                    <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-4">
                        {{ $t('articles_link_label') }}
                    </dt>
                    <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-4">
                        {{ form.project_articles }}
                    </dt>
                    <dt
                        class="flex items-center justify-end col-span-12 gap-6 text-base font-medium leading-6 text-gray-700 md:col-span-4"
                    >
                        <button class="block text-sm font-medium text-blue-500">{{ $t('delete') }}</button>

                        <EditModal @action="editField()">
                            <InputWithIcon
                                class="w-full"
                                :label="$t('articles_link_label')"
                                color="gray-700"
                                icon="https://"
                                type="text"
                                v-model="form.project_articles"
                            />
                        </EditModal>
                    </dt>
                </div>
            </dl>
        </div>
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
