<template>
    <DashboardLayout>
        <!-- Inertia page head -->
        <Title :title="$t('regional.project.edit_page_title')" />

        <dl class="mt-6 border-t border-gray-100 divide-y divide-gray-100">
            <!-- Edit project name -->
            <Field no-edit :label="$t('regional.project.title')" :errors="form.errors.name">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.name"
                    />
                </template>

                <template #action>
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
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.description')" alt :errors="form.errors.description">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.description"
                    />
                </template>

                <template #action>
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
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.counties')" :errors="form.errors.counties">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.counties?.map((item) => item.name).join(', ')"
                    />
                </template>

                <template #action>
                    <EditModal @action="editField('counties')" class="flex justify-end col-span-1">
                        <SelectMultiple
                            class="w-full xl:w-1/2"
                            :label="$t('regional.project.counties')"
                            :options="counties"
                            v-model="form.counties"
                            :error="form.errors.counties"
                        />
                    </EditModal>
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.start_date')" alt :errors="form.errors.start_date">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.start_date"
                    />
                </template>

                <template #action>
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
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.end_date')" :errors="form.errors.end_date">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.end_date"
                    />
                </template>

                <template #action>
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
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.categories')" alt :errors="form.errors.categories">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.categories?.map((item) => item.name).join(', ')"
                    />
                </template>

                <template #action>
                    <EditModal @action="editField('categories')" class="flex justify-end col-span-1">
                        <SelectMultiple
                            class="w-full"
                            :label="$t('project_category_label')"
                            :options="props.projectCategories"
                            v-model="form.categories"
                            :error="form.errors.categories"
                        />
                    </EditModal>
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.youth')" :errors="form.errors.youth">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.youth ? 'da' : 'nu'"
                    />
                </template>

                <template #action>
                    <EditModal @action="editField('youth')" class="flex justify-end col-span-1">
                        <Checkbox name="youth" v-model:checked="form.youth" />
                        <span class="ml-2 text-sm text-gray-700">{{ $t('regional.project.youth') }}</span>

                        <!-- Error -->
                        <p v-show="form.errors.youth" class="mt-2 text-sm text-red-600">
                            {{ form.errors.youth }}
                        </p>
                    </EditModal>
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.identified_need')" alt :errors="form.errors.identified_need">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.reason"
                    />
                </template>

                <template #action>
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
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.proposed_solution')" :errors="form.errors.solution">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.solution"
                    />
                </template>

                <template #action>
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
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.project_details')" alt :errors="form.errors.project_details">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.project_details"
                    />
                </template>

                <template #action>
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
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.what_is_special')" :errors="form.errors.special">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.special"
                    />
                </template>

                <template #action>
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
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.key_results')" alt :errors="form.errors.results">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.results"
                    />
                </template>

                <template #action>
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
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.pride_success')" :errors="form.errors.proud">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.proud"
                    />
                </template>

                <template #action>
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
                </template>
            </Field>

            <Field no-edit :label="$t('photo_gallery')" alt :errors="form.errors.gallery">
                <template #value>
                    <div class="flex flex-wrap items-center gap-6 md:gap-8">
                        <div class="aspect-1 shrink-0" v-for="(image, index) in form.gallery" :key="index">
                            <img class="object-cover w-32 h-32" :src="image.url" alt="" />
                        </div>
                    </div>
                </template>

                <template #action>
                    <EditModal @action="editField('gallery')" @cancel="resetField('gallery')">
                        <FileGroup v-model="form.gallery" :label="$t('photo_gallery')" />
                    </EditModal>
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.had_partners')" :errors="form.errors.partnership">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.partnership ? 'da' : 'nu'"
                    />
                </template>

                <template #action>
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
                </template>
            </Field>

            <Field
                no-edit
                :label="$t('regional.project.partners')"
                alt
                v-if="form.partnership"
                :errors="form.errors.partnership_details"
            >
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.partnership_details"
                    />
                </template>

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
            </Field>

            <Field no-edit :label="$t('regional.project.project_budget')" :errors="form.errors.budget_details">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.budget_details"
                    />
                </template>

                <template #action>
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
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.participant_count_no')" alt :errors="form.errors.participants">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.participants"
                    />
                </template>

                <template #action>
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
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.project_team')" :errors="form.errors.team_details">
                <template #value>
                    <dt
                        class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                        v-text="form.team_details"
                    />
                </template>

                <template #action>
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
                </template>
            </Field>

            <Field no-edit :label="$t('regional.project.contact_info')" alt :errors="form.errors.contact_info">
                <template #value>
                    <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                        <div class="flex items center">
                            <div class="flex flex-col">
                                <span v-text="form.contact?.name" />
                                <span v-text="form.contact?.email" />
                                <span v-text="form.contact?.phone" />
                            </div>
                        </div>
                    </dt>
                </template>

                <template #action>
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
                </template>
            </Field>
        </dl>
    </DashboardLayout>
</template>

<script setup>
/** Import from inertia. */
import { useForm } from '@inertiajs/vue3';

/** Import components. */
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { ref } from 'vue';
import Textarea from '@/Components/form/Textarea.vue';
import Checkbox from '@/Components/form/Checkbox.vue';
import Field from '@/Components/Field.vue';
import Input from '@/Components/form/Input.vue';
import SelectMultiple from '@/Components/form/SelectMultiple.vue';
import FileGroup from '@/Components/form/FileGroup.vue';
import EditModal from '@/Components/modals/EditModal.vue';

const props = defineProps({
    project: Object,
    errors: Object,
    counties: Array,
    projectCategories: Array,
    success_message: String,
    error_message: String,
});

let project = ref(props.project);
let form = useForm(project.value);
</script>
