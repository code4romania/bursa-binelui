<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('my_organization_title')" />

        <!-- Dashboard template -->
        <Dashboard>
            <div class="w-full mb-24 p-9">

                <!-- Header -->
                <header class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                        <SvgLoader class="shrink-0" name="menu"/>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $t('edit_project_title') }}</h2>
                </header>

                <!-- Alert -->
                <!-- <Alert
                    class="fixed z-50 right-10 top-10 w-96"
                    :type="flash?.error_message ? 'error' : flash?.success_message ? 'success' : false"
                    :message="flash?.success_message || flash?.error_message"
                    @emptyFlash="Object.assign(flash, { success_message:'', error_message:'' });"
                /> -->

                <div class="mt-6 border border-gray-100">
                    <dl class="divide-y divide-gray-100">

                        <!-- Edit organization name -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">{{ $t('organization_name_label') }}</dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">{{ clonedOrganization.name }}</dt>
                            <EditModal
                                @action="editField"
                                @cancel="form.name = clonedOrganization.name"
                                class="flex justify-end col-span-1"
                            >
                                <Input
                                    class="w-full"
                                    :label="$t('organization_name_label')"
                                    color="gray-700"
                                    id="organization-name"
                                    type="text"
                                    v-model="form.name"
                                    :error="form.errors.name"
                                />

                            </EditModal>
                        </div>

                        <!-- Edit organization cif -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-white">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">{{ $t('cif_label') }}</dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">{{ clonedOrganization.cif }}</dt>
                            <EditModal
                                @action="editField"
                                @cancel="form.cif = clonedOrganization.cif"
                                class="flex justify-end col-span-1"
                            >
                                <FileInput
                                    class="w-full"
                                    :label="$t('cif_label')"
                                    color="gray-700"
                                    v-model="form.cif"
                                    :error="form.errors.cif"
                                />

                            </EditModal>
                        </div>

                        <!-- Edit organization image -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">{{ $t('organization_logo_label') }}</dt>
                            <dt class="flex items-center col-span-12 gap-6 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                                <img class="flex-shrink-0 w-32 h-32" :src="clonedOrganization.cover_image" alt="" />

                                <div>
                                    <EditModal
                                        @action="editField"
                                        :text="$t('change_image_label')"
                                    >
                                        <Input
                                            class="w-full"
                                            :label="$t('organization_logo_label')"
                                            color="gray-700"
                                            id="organization-image"
                                            @change="handleFileChange"
                                            type="file"
                                        />

                                    </EditModal>

                                    <ModalAction
                                        triggerModalClasses="block text-sm font-medium leadin-5 text-blue-500"
                                        :triggerModalText="$t('delete_image_label')"
                                        :cancelModalText="$t('cancel')"
                                        :actionModalText="$t('delete')"
                                        :title="$t('confirm')"
                                        :body="`${$t('confirm_delete_image_text')}`"
                                        :actionRoute="route('organization.remove_cover_image', form.id)"
                                        :data="form"
                                    />
                                </div>
                            </dt>
                        </div>

                        <!-- Edit organization description -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-white">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">{{ $t('organization_description_label') }}</dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">{{ clonedOrganization.description }}</dt>
                            <EditModal
                                @action="editField"
                                @cancel="form.description = clonedOrganization.description"
                                class="flex justify-end col-span-1"
                            >
                                <Textarea
                                        class="w-full"
                                        :label="$t('organization_description_label')"
                                        id="organization-description"
                                        color="gray-700"
                                        v-model="form.description"
                                        :error="form.errors.description"
                                />

                            </EditModal>
                        </div>

                        <!-- Edit activity domains -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">{{ $t('organization_activity_label') }}</dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">{{ clonedOrganization.activity_domains?.map(item=>item.name).join(', ') }}</dt>
                            <EditModal
                                @action="editField"
                                @cancel="form.activity_domains = clonedOrganization.activity_domains"
                                class="flex justify-end col-span-1"
                            >

                                <MultiSelectObjectFilter
                                    class="w-full"
                                    :label="$t('organization_activity_label')"
                                    :options="activity_domains"
                                    v-model="form.activity_domains"
                                    :error="form.errors.activity_domains"
                                />

                            </EditModal>
                        </div>

                        <!-- Edit activity domains -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-white">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">{{ $t('status_document_label') }}</dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">{{ clonedOrganization.status_document }}</dt>
                            <EditModal
                                @action="editField"
                                @cancel="form.status_document = clonedOrganization.status_document"
                                class="flex justify-end col-span-1"
                            >
                                <Input
                                    class="w-full"
                                    :label="$t('status_document_label')"
                                    color="gray-700"
                                    id="status-document"
                                    type="text"
                                    v-model="form.status_document"
                                    :error="form.errors.status_document"
                                />

                            </EditModal>
                        </div>
                    </dl>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 my-9">{{ $t('volunteer') }}</h2>

                <div class="border border-gray-100">
                    <dl class="divide-y divide-gray-100">

                        <!-- Edit accepts voluntiers -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">{{ $t('organization_accepts_volunteers_label') }}</dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">{{ clonedOrganization.accepts_volunteers ? $t('yes') : $t('no') }}</dt>
                            <EditModal
                                @action="editField"
                                @cancel="form.accepts_volunteers = clonedOrganization.accepts_volunteers"
                                class="flex justify-end col-span-1"
                            >
                                <label class="flex items-center">
                                    <Checkbox
                                        name="accepts_volunteers"
                                        v-model:checked="form.accepts_volunteers"
                                    />
                                    <span class="ml-2 text-sm text-gray-700">{{ $t('organization_accepts_volunteers_label') }}</span>

                                    <!-- Error -->
                                    <p v-show="form.errors.accepts_volunteers" class="mt-2 text-sm text-red-600">{{ form.errors.accepts_volunteers }}</p>
                                </label>

                            </EditModal>
                        </div>

                        <!-- Edit why volunteer -->
                        <div class="grid grid-cols-12 gap-6 px-4 py-6 bg-white">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">{{ $t('organization_why_volunteer_label') }}</dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">{{ clonedOrganization.why_volunteer }}</dt>
                            <EditModal
                                @action="editField"
                                @cancel="form.why_volunteer = clonedOrganization.why_volunteer"
                                class="flex justify-end col-span-1"
                            >
                                <Textarea
                                    class="w-full"
                                    :label="$t('organization_why_volunteer_label')"
                                    id="organization-volunteer"
                                    color="gray-700"
                                    v-model="form.why_volunteer"
                                    :error="form.errors.why_volunteer"
                                />

                            </EditModal>
                        </div>
                    </dl>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 my-9">{{ $t('organization_contact') }}</h2>

                <div class="border border-gray-100">
                    <dl class="divide-y divide-gray-100">

                        <!-- Edit organizaton website -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">{{ $t('organization_website_label') }}</dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">{{ clonedOrganization.website }}</dt>
                            <EditModal
                                @action="editField"
                                @cancel="form.website = clonedOrganization.website"
                                class="flex justify-end col-span-1"
                            >
                                <Input
                                    class="w-full"
                                    :label="$t('organization_website_label')"
                                    color="gray-700"
                                    id="website"
                                    type="text"
                                    v-model="form.website"
                                    :error="form.errors.website"
                                />

                            </EditModal>
                        </div>

                        <!-- Edit organizaton email -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-white">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">{{ $t('organization_email_label') }}</dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">{{ clonedOrganization.contact_email }}</dt>
                            <EditModal
                                @action="editField"
                                @cancel="form.email = clonedOrganization.contact_email"
                                class="flex justify-end col-span-1"
                            >
                                <Input
                                    class="w-full"
                                    :label="$t('organization_email_label')"
                                    color="gray-700"
                                    id="email"
                                    type="email"
                                    v-model="form.email"
                                    :error="form.errors.email"
                                />

                            </EditModal>
                        </div>

                        <!-- Edit organizaton phone -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">{{ $t('organization_phone_label') }}</dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">{{ clonedOrganization.contact_phone }}</dt>
                            <EditModal
                                @action="editField"
                                @cancel="form.phone = clonedOrganization.contact_phone"
                                class="flex justify-end col-span-1"
                            >
                                <Input
                                    class="w-full"
                                    :label="$t('organization_phone_label')"
                                    color="gray-700"
                                    id="phone"
                                    type="number"
                                    v-model="form.phone"
                                    :error="form.errors.phone"
                                />

                            </EditModal>
                        </div>

                        <!-- Edit organizaton contact person -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-white">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">{{ $t('organization_contact_person_label') }}</dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">{{ clonedOrganization.contact_person }}</dt>
                            <EditModal
                                @action="editField"
                                @cancel="form.contact_person = clonedOrganization.contact_person"
                                class="flex justify-end col-span-1"
                            >
                                <Input
                                    class="w-full"
                                    :label="$t('organization_contact_person_label')"
                                    color="gray-700"
                                    id="contact-person"
                                    type="text"
                                    v-model="form.contact_person"
                                    :error="form.errors.contact_person"
                                />

                            </EditModal>
                        </div>

                        <!-- Edit organizaton address -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">{{ $t('organization_address_label') }}</dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">{{ clonedOrganization.street_address }}, {{ clonedOrganization.counties?.map(item=>item.name).join(', ')}} </dt>
                            <EditModal
                                @action="editField"
                                @cancel="form.counties = clonedOrganization.counties; form.street_address = clonedOrganization.street_address"
                                class="flex justify-end col-span-1"
                            >
                                <div class="flex flex-col gap-4 lg:flex-row">

                                    <MultiSelectObjectFilter
                                        class="w-full z-101"
                                        :label="$t('county_label')"
                                        :options="counties"
                                        v-model="form.counties"
                                        :error="form.errors.counties"
                                    />
                                </div>

                                <Input
                                    class="w-full mt-4"
                                    :label="$t('street_address_label')"
                                    color="gray-700"
                                    id="street-addres"
                                    type="text"
                                    v-model="form.street_address"
                                    :error="form.errors.street_address"
                                />

                            </EditModal>
                        </div>
                    </dl>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 my-9">{{ $t('i_pay_title') }}</h2>

                <div class="border border-gray-100">
                    <dl class="divide-y divide-gray-100">

                        <!-- Edit merchant id -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">{{ $t('merchant_id') }}</dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">{{ clonedOrganization.status }}</dt>
                            <EditModal
                                @action="editField"
                                @cancel="form.status = clonedOrganization.status"
                                class="flex justify-end col-span-1"
                            >
                                <Input
                                    class="w-full"
                                    :label="$t('merchant_id')"
                                    color="gray-700"
                                    id="merchant"
                                    type="text"
                                    v-model="form.status"
                                    :error="form.errors.status"
                                />

                            </EditModal>
                        </div>

                        <!-- Edit key -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-white">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">{{ $t('key_label') }}</dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">{{ clonedOrganization.status }}</dt>
                            <EditModal
                                @action="editField"
                                @cancel="form.status = clonedOrganization.status"
                                class="flex justify-end col-span-1"
                            >
                                <Input
                                    class="w-full"
                                    :label="$t('key_label')"
                                    color="gray-700"
                                    id="key-label"
                                    type="text"
                                    v-model="form.status"
                                    :error="form.errors.status"
                                />

                            </EditModal>
                        </div>
                    </dl>
                </div>
            </div>
    </Dashboard>
    </PageLayout>
</template>

<script setup>
    import { ref } from 'vue'
    /** Import from inertia. */
    import { Head, useForm } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Dashboard from '@/Components/templates/Dashboard.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Alert from '@/Components/Alert.vue';
    import EditModal from '@/Components/modals/EditModal.vue';
    import Input from '@/Components/form/Input.vue';
    import Select from '@/Components/form/Select.vue';
    import Textarea from '@/Components/form/Textarea.vue';
    import Checkbox from '@/Components/form/Checkbox.vue';
    import FileInput from '@/Components/form/FileInput.vue';
    import ModalAction from '@/Components/modals/ModalAction.vue';
    import MultiSelectObjectFilter from "@/Components/filters/MultiSelectObjectFilter.vue";
    import {onMounted} from "vue";

    /** Page props. */
    const props = defineProps({
        organization: Object,
        activity_domains: Array,
        counties: Array,
        flash: Object
    });

    /** Initialize inertia from Object. */
    const form = useForm({ ...props.organization });
    const clonedOrganization = ({...props.organization})

    const editField = () => {
        console.log(form);
        form.put(route('admin.ong.update', form.id), {
            preserveScroll: true,
            onSuccess: () => {},
            onError: () => {},
        });
    }
    const handleFileChange = (event) => {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = (() => form.cover_image = reader.result);
            reader.readAsDataURL(file);
        }
        form.cover_image = file;
    }
</script>
