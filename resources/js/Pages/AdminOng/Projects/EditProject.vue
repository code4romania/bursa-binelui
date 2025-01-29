<template>
    <DashboardLayout>
        <Title :title="$t('edit_project_title')" />
        <dl class="mt-6 border-t border-gray-100 divide-y divide-gray-100">
            <Field
                :label="$t('project_name_label')"
                :hasPendingChanges="hasPendingChanges('name')"
                :errors="formChangeStatus.errors.name"
            >
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
            <Field :label="$t('project_slug_label')" :errors="formChangeStatus.errors.slug">
                <template #value>
                    <a :href="route('projects.show', project.slug)" target="_blank" v-text="project.slug" />
                </template>

                <template #action> </template>
            </Field>

            <Field
                :label="$t('amount_target_label')"
                :hasPendingChanges="hasPendingChanges('target_budget')"
                :errors="formChangeStatus.errors.target_budget"
                alt
            >
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

            <Field
                :label="$t('period_start_donation')"
                :hasPendingChanges="hasPendingChanges('start')"
                :errors="formChangeStatus.errors.start || errors.start"
            >
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

            <Field
                :label="$t('period_end_donation')"
                :hasPendingChanges="hasPendingChanges('end')"
                :errors="formChangeStatus.errors.end || errors.end"
                alt
            >
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

            <Field
                :label="$t('project_category_label')"
                :hasPendingChanges="hasPendingChanges('categories')"
                :errors="formChangeStatus.errors.categories"
            >
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

            <Field
                :label="$t('counties_label')"
                :hasPendingChanges="hasPendingChanges('counties')"
                :errors="formChangeStatus.errors.counties"
                alt
            >
                <template #value>
                    {{ originalProject.counties_names }}
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
            <Field
                :label="$t('is_national')"
                :hasPendingChanges="hasPendingChanges('is_national')"
                :errors="formChangeStatus.errors.is_national"
                alt
            >
                <template #value>
                    {{ originalProject.is_national }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('is_national')"
                        @cancel="resetField('is_national')"
                        class="flex justify-end col-span-1"
                    >
                        <fieldset>
                            <legend class="text-sm font-semibold leading-6 text-gray-900">
                                {{ $t('is_national') }}
                            </legend>
                            <div class="mt-6 space-y-6">
                                <div class="relative flex gap-x-3">
                                    <div class="flex items-center h-6">
                                        <Checkbox
                                            class="form-checkbox"
                                            id="accepting_comments"
                                            color="gray-700"
                                            v-model="project.is_national"
                                            :checked="project.is_national === 'Da'"
                                            :error="errors.is_national"
                                        />
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="accepting_comments" class="font-medium text-gray-900">
                                            {{ $t('is_national') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </EditModal>
                </template>
            </Field>

            <Field
                :label="$t('project_description_label')"
                :hasPendingChanges="hasPendingChanges('description')"
                :errors="formChangeStatus.errors.description"
            >
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
                            {{ $t('project_description_extra') }}
                        </Textarea>
                    </EditModal>
                </template>
            </Field>

            <Field
                :label="$t('project_scope_label')"
                :hasPendingChanges="hasPendingChanges('scope')"
                :errors="formChangeStatus.errors.scope"
                alt
            >
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
                            {{ $t('project_scope_extra') }}
                        </Textarea>
                    </EditModal>
                </template>
            </Field>

            <Field
                :label="$t('project_beneficiary_label')"
                :hasPendingChanges="hasPendingChanges('beneficiaries')"
                :errors="formChangeStatus.errors.beneficiaries"
            >
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
                            {{ $t('project_beneficiary_extra') }}
                        </Textarea>
                    </EditModal>
                </template>
                <template #error>
                    <p class="mt-2 text-sm text-red-600" v-if="errors.beneficiaries" v-text="errors.beneficiaries"></p>
                </template>
            </Field>

            <Field
                :label="$t('why_to_donate')"
                :hasPendingChanges="hasPendingChanges('reason_to_donate')"
                :errors="formChangeStatus.errors.reason_to_donate"
                alt
            >
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
                            {{ $t('why_to_donate_extra') }}
                        </Textarea>
                    </EditModal>
                </template>
            </Field>

            <Field
                :label="$t('accepting_volunteers')"
                :hasPendingChanges="hasPendingChanges('accepting_volunteers')"
                :errors="formChangeStatus.errors.accepting_volunteers"
            >
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
                            <legend class="text-sm font-semibold leading-6 text-gray-900">
                                {{ $t('accepting_volunteers') }}
                            </legend>
                            <div class="mt-6 space-y-6">
                                <div class="relative flex gap-x-3">
                                    <div class="flex items-center h-6">
                                        <Checkbox
                                            class="form-checkbox"
                                            id="accepting_comments"
                                            color="gray-700"
                                            v-model="project.accepting_volunteers"
                                            :checked="project.accepting_volunteers === 'Da'"
                                            :error="errors.accepting_volunteers"
                                        />
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="accepting_comments" class="font-medium text-gray-900">
                                            {{ $t('accepting_volunteers') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </EditModal>
                </template>
            </Field>

            <Field
                :label="$t('accepting_comments')"
                :hasPendingChanges="hasPendingChanges('accepting_comments')"
                :errors="formChangeStatus.errors.accepting_comments"
                alt
            >
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
                            <legend class="text-sm font-semibold leading-6 text-gray-900">
                                {{ $t('accepting_comments') }}
                            </legend>
                            <div class="mt-6 space-y-6">
                                <div class="relative flex gap-x-3">
                                    <div class="flex items-center h-6">
                                        <Checkbox
                                            class="form-checkbox"
                                            id="accepting_comments"
                                            color="gray-700"
                                            v-model="project.accepting_comments"
                                            :checked="project.accepting_comments === 'Da'"
                                            :error="errors.accepting_comments"
                                        />
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="accepting_comments" class="font-medium text-gray-900">{{
                                            $t('accepting_comments')
                                        }}</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </EditModal>
                </template>
            </Field>

            <Field :label="$t('main_image')" :errors="formChangeStatus.errors.image || errors.image">
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
                                    @upload="(file) => (project.image = file)"
                                    :form="project.image"
                                    accept="image/png, image/jpeg"
                                    previewable
                                />
                            </EditModal>
                        </div>
                    </div>
                </template>
            </Field>

            <Field :label="$t('photo_gallery')" :errors="formChangeStatus.errors.gallery">
                <template #value v-if="!showSpinner">
                    <div class="flex flex-wrap items-center gap-6 md:gap-8">
                        <div class="aspect-1 shrink-0" v-for="(image, index) in originalProject.gallery" :key="index">
                            <img class="object-cover w-32 h-32" :src="image.url" alt="" />
                        </div>
                    </div>
                </template>
                <template #value v-else>
                    <div class="flex items">
                        <Icon class="animate-spin -ml-1 mr-3 h-5 w-5 text-primary-500" name="spinner" />
                    </div>
                </template>

                <template #action>
                    <EditModal @action="editField('gallery')" @cancel="resetField('gallery')">
                        <FileGroup v-model="project.gallery" :label="$t('photo_gallery')" />
                    </EditModal>
                </template>
            </Field>

            <Field :label="$t('video_link_label')" alt :errors="formChangeStatus.errors.videos || arrayError('videos')">
                <template #value>
                    <div class="flex items-center col-span-12 gap-6 text-base font-medium leading-6 text-gray-700">
                        <div class="grid gap-4">
                            <a
                                v-for="(link, index) in originalProject.videos"
                                :key="index"
                                :href="link.url"
                                target="_blank"
                                v-text="link.url"
                            />
                        </div>
                    </div>
                </template>
                <template #action>
                    <EditModal
                        @action="editField('videos')"
                        class="flex justify-end col-span-1"
                        :errors="formChangeStatus.errors.videos"
                        :label="$t('project.labels.videos')"
                        :description="$t('project.labels.videos_extra')"
                    >
                        <RepeaterComponent
                            :elements="project.videos"
                            :structure="[
                                {
                                    label: $t('video_link_label'),
                                    key: 'url',
                                    error: arrayError('videos'),
                                },
                            ]"
                            :error="arrayError('videos')"
                            name="videos"
                        />
                    </EditModal>
                </template>
            </Field>

            <Field
                :label="$t('external_links_title')"
                :errors="formChangeStatus.errors.external_links || arrayError('external_links')"
            >
                <template #value>
                    <div class="flex items-center col-span-12 gap-6 text-base font-medium leading-6 text-gray-700">
                        <div class="grid gap-4">
                            <a
                                v-for="(link, index) in originalProject.external_links"
                                :key="index"
                                :href="link.url"
                                v-text="link.title"
                                target="_blank"
                                class="p-2 mx-2 border-2"
                            />
                        </div>
                    </div>
                </template>
                <template #action>
                    <EditModal
                        @action="editField('external_links')"
                        class="flex justify-end col-span-1"
                        :errors="arrayError('external_links')"
                        :label="$t('external_links_title')"
                    >
                        <RepeaterComponent
                            :elements="project.external_links"
                            name="external_links"
                            :structure="[
                                {
                                    label: $t('project.labels.external_links_title'),
                                    key: 'title',
                                    error: arrayError('external_links'),
                                },
                                {
                                    label: $t('project.labels.external_links_url'),
                                    key: 'url',
                                    error: arrayError('external_links'),
                                },
                            ]"
                        />
                    </EditModal>
                </template>
            </Field>
            <SecondaryButton
                v-if="!project.is_active && !project.is_pending && !project.can_be_archived && !project.active"
                class="w-full mt-4 py-2.5 text-primary-500 ring-1 ring-inset ring-primary-500 hover:bg-primary-400"
                @click="changeProjectStatus(project.id, 'pending', project.type)"
                :label="$t('publish')"
            />
        </dl>
    </DashboardLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import route from '@/Helpers/useRoute';

/** Import components. */
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Title from '@/Components/Title.vue';
import Field from '@/Components/Field.vue';
import EditModal from '@/Components/modals/EditModal.vue';
import Input from '@/Components/form/Input.vue';
import Textarea from '@/Components/form/Textarea.vue';
import FileInput from '@/Components/form/FileInput.vue';
import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
import Select from '@/Components/form/Select.vue';
import Checkbox from '@/Components/form/Checkbox.vue';
import RepeaterComponent from '@/Components/RepeaterComponent.vue';
import FileGroup from '@/Components/form/FileGroup.vue';
import { trans } from 'laravel-vue-i18n';
import Icon from '@/Components/Icon.vue';

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

const showSpinner = ref(false);

const resetField = (field) => {
    project.value[field] = originalProject.value[field];
};

const formChangeStatus = useForm({
    status: 'pending',
    id: project.value.id,
});

const hasPendingChanges = (field) => {
    let tmpChanges = props.changes;
    if (Object.keys(tmpChanges).includes(field)) {
        return tmpChanges[field].new;
    }
    return false;
};

const changeProjectStatus = (id, status, type) => {
    let tmpRoute =
        type === 'regional' ? route('dashboard.projects.gala.status', id) : route('dashboard.projects.status', id);
    if (confirm(trans('project_change_status_publish'))) {
        formChangeStatus.post(tmpRoute, {
            preserveScroll: true,
            onSuccess: (response) => {
                //
            },
            onError: (error) => {
                Object.keys(error).forEach((key) => {
                    if (key.includes('external_links')) {
                        formChangeStatus.errors['external_links'] = error[key];
                    }
                    if (key.includes('videos')) {
                        formChangeStatus.errors['videos'] = error[key];
                    }
                });
                console.log(error);
            },
        });
    }
};

const editField = (field) => {
    if (field === 'gallery') {
        showSpinner.value = true;
    }
    const form = useForm({
        [field]: project.value[field],
    });
    form.post(route('dashboard.projects.update', project.value.id), {
        preserveScroll: true,
        onSuccess: (response) => {
            showSpinner.value = false;
        },
        onFinish: () => {
            showSpinner.value = false;
        },
    });
};
function arrayError(key) {
    let errorMessage = '';
    Object.keys(props?.errors).forEach((error) => {
        if (error.startsWith(key)) {
            errorMessage = props?.errors[error];
        }
    });
    return errorMessage;
}
</script>
