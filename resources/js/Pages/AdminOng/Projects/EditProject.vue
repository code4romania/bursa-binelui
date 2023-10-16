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
            <Field :label="$t('amount_target_label')" :hasPendingChanges="changes.includes('target_budget')" :errors="formChangeStatus.errors.target_amount">
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
            <Field :label="$t('period_start_donation')" alt :errors="formChangeStatus.errors.start">
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
            <Field :label="$t('period_end_donation')" alt :errors="formChangeStatus.errors.end">
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

            <!-- Edit main image -->
            <Field :label="$t('main_image')" :hasPendingChanges="changes.includes('cover_image')" :errors="formChangeStatus.errors.image">
                <template #value>
                    <div class="flex items-center col-span-12 gap-6 text-base font-medium leading-6 text-gray-700">
                        <img class="object-contain w-32 h-32 shrink-0" :src="project.image" alt="" />

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

            <!-- Edit Photo gallery -->
            <Field :label="$t('photo_gallery')" :hasPendingChanges="changes.includes('name')" alt :errors="formChangeStatus.errors.photo_gallery">
                <template #value>
                    <div>Images</div>

                    <div class="flex flex-wrap">
                        <div
                            :style="{backgroundImage: `url(${image.url})` }"
                            style="background-size: contain"
                            v-for="(image, index) in project.gallery"
                            :key="index"
                            class="grid content-end grid-cols-2 gap-4 mx-2 my-2 w-60 h-60"
                        >
                            <DangerButton @click="removeImage(index)">{{ $t('remove_image') }} </DangerButton>
                            <SecondaryButton class="col-start-2" @click="setCoverImage(index)"
                                >{{ $t('set_cover_image') }}
                            </SecondaryButton>
                        </div>
                    </div>
                </template>

                <template #action>
                    <EditModal
                        @action="editField('gallery')"
                        @cancel="resetField('gallery')"
                        :text="$t('change_images_label')"
                    >
                        <FileInput
                            :label="$t('upload_image')"
                            @upload="(file) => (project.gallery = file)"
                            :form="project.gallery"
                            accept="image/png, image/jpeg"
                            previewable
                            multiple
                        />
                    </EditModal>
                </template>
            </Field>

            <!-- Edit video links -->
            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                    {{ $t('video_link_label') }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ project.video }}
                </dt>
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    {{ project.project_links }}
                </dt>
                <EditModal @action="editField('project_links')" class="flex justify-end col-span-1" :errors="formChangeStatus.errors.project_links">
                    <Repeater class="w-full xl:w-1/2">
                        <InputWithIcon
                            class="w-full"
                            :label="$t('video_link_label')"
                            color="gray-700"
                            icon="https://"
                            type="text"
                            v-model="project.project_links"
                        />
                    </Repeater>
                </EditModal>
            </div>
        </dl>

        <div class="flex items-center gap-4 mt-9">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                <SvgLoader class="shrink-0 fill-primary-500" name="book" />
            </div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $t('external_links_title') }}</h2>
        </div>

        <EditModal @action="editField()" btnClasses="" class="mt-9" :errors="formChangeStatus.errors.project_articles">
            <InputWithIcon
                class="w-full"
                :label="$t('articles_link_label')"
                color="gray-700"
                icon="https://"
                type="text"
                v-model="project.project_articles"
            />
        </EditModal>

        <div class="mt-6 border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
                <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                    <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-4">
                        {{ $t('articles_link_label') }}
                    </dt>
                    <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-4">
                        {{ project.project_articles }}
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
                                v-model="project.project_articles"
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

        // if (field ==='counties') {
        //     console.log(props.counties.find(form.counties));
        //     project.counties_names = props.counties.find(form.counties);
        // }
        // console.log(form,field);

        form.post(route('dashboard.projects.update', project.value.id), {
            preserveScroll: true,
            onSuccess: (response) => {
                //
            },
        });
    };
</script>
