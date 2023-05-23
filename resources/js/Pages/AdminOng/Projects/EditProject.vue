<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('edit_project_title')" />

        <!-- Alert -->
        <Alert
            class="fixed right-10 top-10 w-96 z-50"
            :type="flash.error_message ? 'error' : flash.success_message ? 'success' : false"
            :message="flash.success_message || flash.error_message"
            @emptyFlash="Object.assign(flash, { success_message:'', error_message:'' });"
        />

        <!-- Dashboard template -->
        <Dashboard>
           <div class="p-9 mb-24 w-full">

                <!-- Header -->
                <header class="flex items-center gap-4">
                    <div class="bg-turqoise-500 w-8 h-8 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0" name="menu"/>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $t('edit_project_title') }}</h2>
                </header>


                <div class="mt-6 border-t border-gray-100">
                    <dl class="divide-y divide-gray-100">

                        <!-- Edit project name -->
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('project_name_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.name }}</dt>
                            <EditModal
                                @action="editField('name')"
                                class="col-span-1 flex justify-end"
                            >

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
                        <div class="bg-white px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('amount_target_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.target_budget }}</dt>
                            <EditModal
                                @action="editField('target_budget')"
                                class="col-span-1 flex justify-end"
                            >

                                <Input
                                    class="w-full"
                                    :label="$t('amount_target_label')"
                                    color="gray-700"
                                    id="amount-target"
                                    type="number"
                                    v-model="form.target_budget"
                                    :error="form.errors.target_budget"
                                />

                            </EditModal>
                        </div>

                        <!-- Edit period -->
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('period') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.start }} - {{ form.end }}</dt>
                            <EditModal
                                @action="editField('start', 'end')"
                                class="col-span-1 flex justify-end"
                            >

                            <div class="flex gap-6 w-full">

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
                            </div>

                            </EditModal>
                        </div>

                        <!-- Edit project category -->
                        <div class="bg-white px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('project_category_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.category }}</dt>
                            <EditModal
                                @action="editField('category')"
                                class="col-span-1 flex justify-end"
                            >

                                <Select
                                    class="w-full"
                                    :label="$t('project_category_label')"
                                    :options="props.projectCategories"
                                    v-model="form.category"
                                    :error="form.errors.category"
                                />

                            </EditModal>
                        </div>


                        <!-- Edit project county -->
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('counties_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.county }}</dt>
                            <EditModal
                                @action="editField('counties')"
                                class="col-span-1 flex justify-end"
                            >

                                <Select
                                    class="w-full xl:w-1/2"
                                    :label="$t('counties_label')"
                                    :options="counties"
                                    v-model="form.county"
                                    :error="form.errors.county"
                                />

                            </EditModal>
                        </div>

                        <!-- Edit project description -->
                        <div class="bg-white px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('project_description_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.description }}</dt>
                            <EditModal
                                @action="editField('description')"
                                class="col-span-1 flex justify-end"
                            >

                                <Textarea
                                    class="w-full"
                                    :label="$t('project_description_label')"
                                    id="about-project"
                                    color="gray-700"
                                    v-model="form.description"
                                    :error="form.errors.description"
                                >
                                    <p class="text-sm font-normal text-gray-500">{{ $t('project_description_extra') }}</p>
                                </Textarea>

                            </EditModal>
                        </div>

                        <!-- Edit project scope -->
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('project_scope_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.scope }}</dt>
                            <EditModal
                                @action="editField('scope')"
                                class="col-span-1 flex justify-end"
                            >

                                <Textarea
                                    class="w-full"
                                    :label="$t('project_scope_label')"
                                    id="project-scope"
                                    color="gray-700"
                                    v-model="form.scope"
                                    :error="form.errors.scope"
                                >
                                    <p class="text-sm font-normal text-gray-500">{{ $t('project_scope_extra') }}</p>
                                </Textarea>

                            </EditModal>
                        </div>

                        <!-- Edit project beneficiary -->
                        <div class="bg-white px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('project_beneficiary_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.beneficiaries }}</dt>
                            <EditModal
                                @action="editField('beneficiaries')"
                                class="col-span-1 flex justify-end"
                            >

                                <Textarea
                                    class="w-full"
                                    :label="$t('project_beneficiary_label')"
                                    id="project-beneficiary"
                                    color="gray-700"
                                    v-model="form.beneficiaries"
                                    :error="form.errors.beneficiaries"
                                >
                                    <p class="text-sm font-normal text-gray-500">{{ $t('project_beneficiary_extra') }}</p>
                                </Textarea>

                            </EditModal>
                        </div>

                        <!-- Edit project why to donate -->
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('why_to_donate') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.reason_to_donate }}</dt>
                            <EditModal
                                @action="editField('reason_to_donate')"
                                class="col-span-1 flex justify-end"
                            >

                                <Textarea
                                    class="w-full"
                                    :label="$t('why_to_donate')"
                                    id="why-to-donate"
                                    color="gray-700"
                                    v-model="form.reason_to_donate"
                                    :error="form.errors.reason_to_donate"
                                >
                                    <p class="text-sm font-normal text-gray-500">{{ $t('why_to_donate_extra') }}</p>
                                </Textarea>

                            </EditModal>
                        </div>

                        <!-- Edit main image -->
                        <div class="bg-white px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('main_image') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.image }}</dt>
                            <EditModal
                                @action="editField()"
                                class="col-span-1 flex justify-end"
                            >

                                <Textarea
                                    class="w-full"
                                    :label="$t('why_to_donate')"
                                    id="why-to-donate"
                                    color="gray-700"
                                    v-model="form.reson_to_donate"
                                    :error="form.errors.reson_to_donate"
                                >
                                    <p class="text-sm font-normal text-gray-500">{{ $t('why_to_donate_extra') }}</p>
                                </Textarea>

                            </EditModal>
                        </div>

                        <!-- Edit Photo gallery -->
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('photo_gallery') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">

                                <div>
                                    Images
                                </div>

                                <!-- File group -->
                                <FileGroup
                                    v-model="form.file_group"
                                />
                            </dt>

                            <EditModal
                                @action="editField()"
                                class="col-span-1 flex justify-end"
                            >

                                <Textarea
                                    class="w-full"
                                    :label="$t('why_to_donate')"
                                    id="why-to-donate"
                                    color="gray-700"
                                    v-model="form.why_to_donate"
                                    :error="form.errors.why_to_donate"
                                >
                                    <p class="text-sm font-normal text-gray-500">{{ $t('why_to_donate_extra') }}</p>
                                </Textarea>

                            </EditModal>
                        </div>

                        <!-- Edit video links -->
                        <div class="bg-white px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('video_link_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.image }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.project_links }}</dt>
                            <EditModal
                                @action="editField('project_links')"
                                class="col-span-1 flex justify-end"
                            >

                                <Repeater class="w-full xl:w-1/2">
                                    <InputWithIcon
                                        class="w-full"
                                        :label="$t('video_link_label')"
                                        color="gray-700"
                                        icon="htpp://"
                                        type="text"
                                        v-model="form.project_links"
                                    />
                                </Repeater>

                            </EditModal>
                        </div>
                    </dl>
                </div>

                <div class="flex items-center gap-4 mt-9">
                    <div class="bg-turqoise-500 w-8 h-8 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0 fill-turqoise-500" name="book"/>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $t('external_links_title') }}</h2>
                </div>

                <EditModal
                    @action="editField()"
                    btnClasses =""
                    class="mt-9"
                >
                    <InputWithIcon
                        class="w-full"
                        :label="$t('articles_link_label')"
                        color="gray-700"
                        icon="htpp://"
                        type="text"
                        v-model="form.project_articles"
                    />

                </EditModal>

                <div class="mt-6 border-t border-gray-100">
                    <dl class="divide-y divide-gray-100">
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-4 text-base font-medium leading-6 text-gray-700">{{ $t('articles_link_label') }}</dt>
                            <dt class="col-span-12 md:col-span-4 text-base font-medium leading-6 text-gray-700">{{ form.project_articles }}</dt>
                            <dt class="col-span-12 md:col-span-4 flex items-center justify-end gap-6 text-base font-medium leading-6 text-gray-700">
                                <button class="block text-sm font-medium text-blue-500">{{ $t('delete') }}</button>

                                <EditModal
                                    @action="editField()"
                                >
                                    <InputWithIcon
                                        class="w-full"
                                        :label="$t('articles_link_label')"
                                        color="gray-700"
                                        icon="htpp://"
                                        type="text"
                                        v-model="form.project_articles"
                                    />

                                </EditModal>
                            </dt>
                        </div>
                    </dl>
                </div>
           </div>
        </Dashboard>
    </PageLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { Head, Link, useForm } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Dashboard from '@/Components/templates/Dashboard.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Alert from '@/Components/Alert.vue';
    import EditModal from '@/Components/modals/EditModal.vue';
    import Input from '@/Components/form/Input.vue';
    import Select from '@/Components/form/Select.vue';
    import Textarea from '@/Components/form/Textarea.vue';
    import FileGroup from '@/Components/form/FileGroup.vue';
    import Repeater from '@/Components/form/Repeater.vue';
    import InputWithIcon from '@/Components/form/InputWithIcon.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import {onMounted, ref} from "vue";

    const flash = {
        success_message:'',
        error_message:''
    }

    const props = defineProps({
        project: Object,
        errors: Object,
        projectCategories: Array,
        success_message: String,
        error_message: String
    });

    let project = ref(props.project);
    let form = useForm(project.value);

    const  editField = (field) => {
        let newForm = useForm({
            [field]: form[field]
        })
        newForm.put(route('admin.ong.project.update', project.value.id))
    }


</script>
