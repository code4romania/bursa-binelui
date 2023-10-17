<template>
    <DashboardLayout>
        <Title :title="$t('edit_project_title')" />
        <dl class="mt-6 border-t border-gray-100 divide-y divide-gray-100">
            <!-- Edit project name -->
            <Field :label="$t('project_name_label')" :hasPendingChanges="changes.includes('name')" alt :errors="formChangeStatus.errors.name">
                <template #value>
                    {{ project.name }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('name')"
                        @cancel="resetField('name')"
                        class="flex justify-end col-span-1"
                    >
                        <!-- Project name -->
                        <Input
                            class="w-full"
                            :label="$t('project_name_label')"
                            color="gray-700"
                            id="project-name"
                            type="text"
                            v-model="project.name"
                            :error="errors.name"
                        />
                    </EditModal>
                </template>
            </Field>

            <!-- Edit target amount -->
            <Field :label="$t('amount_target_label')" :hasPendingChanges="changes.includes('target_budget')" :errors="formChangeStatus.errors.target_budget">
                <template #value>
                    {{ project.target_budget }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('target_budget')"
                        @cancel="resetField('target_budget')"
                        class="flex justify-end col-span-1"
                    >
                        <Input
                            class="w-full"
                            :label="$t('amount_target_label')"
                            color="gray-700"
                            id="amount-target"
                            type="number"
                            v-model="project.target_budget"
                            :error="errors.target_budget"
                        />
                    </EditModal>
                </template>
            </Field>

            <!-- Edit period -->
            <Field :label="$t('period_start_donation')" alt :hasPendingChanges="changes.includes('start')" :errors="formChangeStatus.errors.start">
                <template #value> {{ project.start }} </template>

                <template #action>
                    <EditModal
                        @action="editField('start', 'end')"
                        @cancel="resetField('start', 'end')"
                        class="flex justify-end col-span-1"
                    >
                        <div class="flex w-full gap-6">
                            <!-- Date start -->
                            <Input
                                class="w-full xl:w-1/2"
                                :label="$t('project_date_start_label')"
                                color="gray-700"
                                type="date"
                                v-model="project.start"
                                :error="errors.start"
                            />
                        </div>
                    </EditModal>
                </template>
            </Field>
            <Field :label="$t('period_end_donation')" alt :hasPendingChanges="changes.includes('end')" :errors="formChangeStatus.errors.end">
                <template #value>{{ project.end }} </template>

                <template #action>
                    <EditModal
                        @action="editField('end')"
                        @cancel="resetField('end')"
                        class="flex justify-end col-span-1"
                    >
                        <div class="flex w-full gap-6">
                            <!-- Date start -->
                            <Input
                                class="w-full xl:w-1/2"
                                :label="$t('project_date_end_label')"
                                color="gray-700"
                                type="date"
                                v-model="project.end"
                                :error="errors.end"
                            />
                        </div>
                    </EditModal>
                </template>
            </Field>

            <!-- Edit project category -->
            <Field :label="$t('project_category_label')" :hasPendingChanges="changes.includes('categories')" :errors="formChangeStatus.errors.categories">
                <template #value>
                    {{ originalProject.categories_names }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('categories')"
                        @cancel="resetField('categories')"
                        class="flex justify-end col-span-1"
                    >
                        <Select
                            :label="$t('project_category_label')"
                            :options="projectCategories"
                            v-model="project.categories"
                            :error="errors.categories"
                            :multiple="true"
                        />
                    </EditModal>
                </template>
            </Field>

            <!-- Edit project county -->
            <Field :label="$t('counties_label')" :hasPendingChanges="changes.includes('counties')" :errors="formChangeStatus.errors.counties">
                <template #value>
                    {{ originalProject.counties_names}}

                </template>

                <template #action>
                    <EditModal
                        @action="editField('counties')"
                        @cancel="resetField('counties')"
                        class="flex justify-end col-span-1"
                    >
                        <Select
                            :label="$t('counties_label')"
                            type="singleValue"
                            :options="props.counties"
                            v-model="project.counties"
                            :error="errors.counties"
                            :multiple="true"
                        />
                    </EditModal>
                </template>
            </Field>

            <!-- Edit project description -->
            <Field :label="$t('project_description_label')" :hasPendingChanges="changes.includes('description')" :errors="formChangeStatus.errors.description">
                <template #value>
                    {{ project.description }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('description')"
                        @cancel="resetField('description')"
                        class="flex justify-end col-span-1"
                    >
                        <Textarea
                            class="w-full"
                            :label="$t('project_description_label')"
                            id="about-project"
                            color="gray-700"
                            v-model="project.description"
                            :error="errors.description"
                        >
                            <p class="text-sm font-normal text-gray-500">
                                {{ $t('project_description_extra') }}
                            </p>
                        </Textarea>
                    </EditModal>
                </template>
            </Field>

            <!-- Edit project scope -->
            <Field :label="$t('project_scope_label')" :hasPendingChanges="changes.includes('scope')" alt  :errors="formChangeStatus.errors.scope">
                <template #value>
                    {{ project.scope }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('scope')"
                        @cancel="resetField('scope')"
                        class="flex justify-end col-span-1"
                    >
                        <Textarea
                            class="w-full"
                            :label="$t('project_scope_label')"
                            id="project-scope"
                            color="gray-700"
                            v-model="project.scope"
                            :error="errors.scope"
                        >
                            <p class="text-sm font-normal text-gray-500">{{ $t('project_scope_extra') }}</p>
                        </Textarea>
                    </EditModal>
                </template>
            </Field>

            <!-- Edit project beneficiary -->
            <Field :label="$t('project_beneficiary_label')" :hasPendingChanges="changes.includes('beneficiaries')" :errors="formChangeStatus.errors.beneficiaries">
                <template #value>
                    {{ project.beneficiaries }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('beneficiaries')"
                        @cancel="resetField('beneficiaries')"
                        class="flex justify-end col-span-1"
                    >
                        <Textarea
                            class="w-full"
                            :label="$t('project_beneficiary_label')"
                            id="project-beneficiary"
                            color="gray-700"
                            v-model="project.beneficiaries"
                            :error="errors.beneficiaries"
                        >
                            <p class="text-sm font-normal text-gray-500">
                                {{ $t('project_beneficiary_extra') }}
                            </p>
                        </Textarea>
                    </EditModal>
                </template>
                <template #error>
                    <p class="mt-2 text-sm text-red-600" v-if="errors.beneficiaries" v-text="errors.beneficiaries"></p>
                </template>
            </Field>

            <!-- Edit project why to donate -->
            <Field :label="$t('why_to_donate')" :hasPendingChanges="changes.includes('reason_to_donate')" alt :errors="formChangeStatus.errors.reason_to_donate">
                <template #value>
                    {{ project.reason_to_donate }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('reason_to_donate')"
                        @cancel="resetField('reason_to_donate')"
                        class="flex justify-end col-span-1"
                    >
                        <Textarea
                            class="w-full"
                            :label="$t('why_to_donate')"
                            id="why-to-donate"
                            color="gray-700"
                            v-model="project.reason_to_donate"
                            :error="errors.reason_to_donate"
                        >
                            <p class="text-sm font-normal text-gray-500">{{ $t('why_to_donate_extra') }}</p>
                        </Textarea>
                    </EditModal>
                </template>
            </Field>
            <Field :label="$t('accepting_volunteers')" :hasPendingChanges="changes.includes('accepting_volunteers')" alt :errors="formChangeStatus.errors.accepting_volunteers">
                <template #value>
                    {{ originalProject.accepting_volunteers }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('accepting_volunteers')"
                        @cancel="resetField('accepting_volunteers')"
                        class="flex justify-end col-span-1"
                    >
                        <fieldset>
                            <legend class="text-sm font-semibold leading-6 text-gray-900">  {{ $t('accepting_volunteers') }}</legend>
                            <div class="mt-6 space-y-6">
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <Checkbox
                                            class="form-checkbox"
                                            id="accepting_comments"
                                            color="gray-700"
                                            v-model="project.accepting_volunteers"
                                            :checked="project.accepting_volunteers==='Da'"
                                            :error="errors.accepting_volunteers"
                                        />
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="accepting_comments" class="font-medium text-gray-900">{{$t('accepting_volunteers')}}</label>
                                        <p class="text-gray-500">{{ $t('accepting_volunteers_extra') }}</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </EditModal>
                </template>
            </Field>

            <Field :label="$t('accepting_comments')" :hasPendingChanges="changes.includes('accepting_comments')" alt :errors="formChangeStatus.errors.accepting_comments">
                <template #value>
                    {{ originalProject.accepting_comments }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('accepting_comments')"
                        @cancel="resetField('accepting_comments')"
                        class="flex justify-end col-span-1"
                    >
                        <fieldset>
                            <legend class="text-sm font-semibold leading-6 text-gray-900">  {{ $t('accepting_comments') }}</legend>
                            <div class="mt-6 space-y-6">
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <Checkbox
                                            class="form-checkbox"
                                            id="accepting_comments"
                                            color="gray-700"
                                            v-model="project.accepting_comments"
                                            :checked="project.accepting_comments==='Da'"
                                            :error="errors.accepting_comments"
                                        />
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="accepting_comments" class="font-medium text-gray-900">{{$t('accepting_comments')}}</label>
                                        <p class="text-gray-500">{{ $t('accepting_comments_extra') }}</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </EditModal>
                </template>
            </Field>

            <!-- Edit main image -->
            <Field :label="$t('main_image')" :errors="formChangeStatus.errors.preview">
                <template #value>
                    <div class="flex items-center col-span-12 gap-6 text-base font-medium leading-6 text-gray-700">
                        <img class="object-contain w-32 h-32 shrink-0" :src="originalProject.image" alt="" />

                        <div>
                            <EditModal
                                @action="editField('image')"
                                @cancel="resetField('image')"
                                :text="$t('change_image_label')"
                            >
                                <FileInput
                                    :label="$t('upload_image')"
                                    @upload="(file) =>(project.image = file)"
                                    :form="project.image"
                                    accept="image/png, image/jpeg"
                                    previewable
                                />
                            </EditModal>
                        </div>
                    </div>
                </template>
            </Field>
            <FileGroup v-model="originalProject.gallery" sync :label="$t('photo_gallery')" @removeImage="removeGalleryImage(id)"/>

        </dl>

        <div class="mt-6 border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
                <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                    <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-4">
                        {{ $t('video_link_label') }}
                    </dt>
                    <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-4">
                        <a v-for="link in originalProject.videos"
                           :href="link.url"
                           target="_blank"
                           class="mx-2 border-2 p-2"
                           v-text="link.url"
                        />
                    </dt>
                    <dt class="flex items-center justify-end col-span-12 gap-6 text-base font-medium leading-6 text-gray-700 md:col-span-4">
                        <EditModal @action="editField('videos')" class="flex justify-end col-span-1" :errors="formChangeStatus.errors.project_links">
                            <RepeaterComponent
                                :elements="originalProject.videos"
                                :label="$t('project.labels.videos')"
                                :description="$t('project.labels.videos_extra')"
                                :structure="[{label:$t('video_link_label'),key:'url',error:arrayError('videos.0.url')}]"
                                :error="arrayError('videos.0.url')"
                                name="videos"
                            />
                        </EditModal>
                    </dt>
                </div>
            </dl>
        </div>

        <div class="mt-6 border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
                <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                    <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-4">
                        {{ $t('external_links_title') }}
                    </dt>
                    <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-4">
                        <a v-for="link in originalProject.external_links"
                           :href="link.url"
                           v-text="link.title"
                           target="_blank"
                           class="mx-2 border-2 p-2"
                        />
                    </dt>
                    <dt class="flex items-center justify-end col-span-12 gap-6 text-base font-medium leading-6 text-gray-700 md:col-span-4">
                        <EditModal @action="editField('external_links')">
                            <RepeaterComponent
                                :elements="originalProject.external_links"
                                :label="$t('external_links_title')"
                                :description="$t('external_links_text')"
                                :structure="[
                        {label:$t('project.labels.external_links_title'),key:'title',error:arrayError('external_links.0.title')},
                        {label:$t('project.labels.external_links_url'),key:'url',error:arrayError('external_links.0.url')}
                        ]" name="external_links"
                            />
                        </EditModal>
                    </dt>
                </div>
            </dl>
        </div>
        <SecondaryButton
            v-if="!project.is_active && !project.is_pending && !project.can_be_archived"
            class="w-full mt-4 py-2.5 text-primary-500 ring-1 ring-inset ring-primary-500 hover:bg-primary-400"
            @click="changeProjectStatus(project.id, 'pending', project.type)"
            :label="$t('publish')"
        />
    </DashboardLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

/** Import components. */
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Title from '@/Components/Title.vue';
import SvgLoader from '@/Components/SvgLoader.vue';
import Field from '@/Components/Field.vue';
import EditModal from '@/Components/modals/EditModal.vue';
import Input from '@/Components/form/Input.vue';
import Textarea from '@/Components/form/Textarea.vue';
import FileInput from '@/Components/form/FileInput.vue';
import Repeater from '@/Components/form/Repeater.vue';
import InputWithIcon from '@/Components/form/InputWithIcon.vue';
import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
import DangerButton from '@/Components/buttons/DangerButton.vue';
import SelectMultiple from '@/Components/form/SelectMultiple.vue';
import Select from "@/Components/form/Select.vue";
import Checkbox from "@/Components/form/Checkbox.vue";
import RepeaterComponent from "@/Components/RepeaterComponent.vue";
import FileGroup from "@/Components/form/FileGroup.vue";

const props = defineProps({
    project: Object,
    errors: Object,
    counties: Array,
    projectCategories: Array,
    flash: Object,
    changes: Array,
});

const project = ref(props.project);
const originalProject = computed(() => props.project);

const resetField = (field) => {
    project.value[field] = originalProject.value[field];
};

const formChangeStatus = useForm({
    status: 'pending',
    id: project.value.id,
});

const changeProjectStatus = (id, status, type) => {
    let tmpRoute =
        type === 'regional' ? route('dashboard.projects.regional.status', id) : route('dashboard.projects.status', id);
    if (confirm('Are you sure you want to change the status of this project?')) {
        formChangeStatus.post(tmpRoute);
    }
};

const editField = (field) => {
    const form = useForm({
        [field]: project.value[field],
    });
    form.post(route('dashboard.projects.update', project.value.id), {
        preserveScroll: true,
        onSuccess: (response) => {
            //
        },
    });

};
function arrayError(key) {
    if (props?.errors[key]) {
        return props?.errors[key];
    }
    return null;
}

</script>
