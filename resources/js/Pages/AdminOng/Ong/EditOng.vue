<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('my_organization_title')" />

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

                <!-- Alert -->
                <!-- <Alert
                    class="fixed right-10 top-10 w-96 z-50"
                    :type="flash.error_message ? 'error' : flash.success_message ? 'success' : false"
                    :message="flash.success_message || flash.error_message"
                    @emptyFlash="Object.assign(flash, { success_message:'', error_message:'' });"
                /> -->

                <div class="mt-6 border border-gray-100">
                    <dl class="divide-y divide-gray-100">

                        <!-- Edit organization name -->
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('organization_name_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.name }}</dt>
                            <EditModal
                                @action="editField"
                                class="col-span-1 flex justify-end"
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
                        <div class="bg-white px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('cif_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.cif }}</dt>
                            <EditModal
                                @action="editField"
                                class="col-span-1 flex justify-end"
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
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('organization_logo_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base flex items-center gap-6 font-medium leading-6 text-gray-700">
                                <img class="h-32 w-32 flex-shrink-0" src="/images/ong.png" alt="" />

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
                                        actionRoute="route('admin.client.destroy', person.user.id)"
                                        :data="form"
                                    />
                                </div>
                            </dt>
                        </div>

                        <!-- Edit organization description -->
                        <div class="bg-white px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('organization_description_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.description }}</dt>
                            <EditModal
                                @action="editField"
                                class="col-span-1 flex justify-end"
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
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('organization_activity_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.activity_domains?.map(item=>item.name).join(', ') }}</dt>
                            <EditModal
                                @action="editField"
                                class="col-span-1 flex justify-end"
                            >
                                <MultiSelectObjectFilter
                                    class="w-full xl:w-1/2"
                                    :label="$t('organization_activity_label')"
                                    :options="activity_domains"
                                    v-model="form.activity_domains"
                                    :error="form.errors.activity_domains"
                                />

                            </EditModal>
                        </div>

                        <!-- Edit activity domains -->
                        <div class="bg-white px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('status_document_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.status_document }}</dt>
                            <EditModal
                                @action="editField"
                                class="col-span-1 flex justify-end"
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

                <h2 class="text-2xl my-9 font-bold text-gray-900">{{ $t('volunteer') }}</h2>

                <div class="border border-gray-100">
                    <dl class="divide-y divide-gray-100">

                        <!-- Edit accepts voluntiers -->
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('organization_accepts_volunteers_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.accepts_volunteers ? $t('yes') : $t('no') }}</dt>
                            <EditModal
                                @action="editField"
                                class="col-span-1 flex justify-end"
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
                        <div class="bg-white px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('organization_why_volunteer_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.why_volunteer }}</dt>
                            <EditModal
                                @action="editField"
                                class="col-span-1 flex justify-end"
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

                <h2 class="text-2xl my-9 font-bold text-gray-900">{{ $t('organization_contact') }}</h2>

                <div class="border border-gray-100">
                    <dl class="divide-y divide-gray-100">

                        <!-- Edit organizaton website -->
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('organization_website_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.website }}</dt>
                            <EditModal
                                @action="editField"
                                class="col-span-1 flex justify-end"
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
                        <div class="bg-white px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('organization_email_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.contact_email }}</dt>
                            <EditModal
                                @action="editField"
                                class="col-span-1 flex justify-end"
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
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('organization_phone_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.contact_phone }}</dt>
                            <EditModal
                                @action="editField"
                                class="col-span-1 flex justify-end"
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
                        <div class="bg-white px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('organization_contact_person_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.contact_person }}</dt>
                            <EditModal
                                @action="editField"
                                class="col-span-1 flex justify-end"
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
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('organization_address_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.street_address }}, {{ form.counties?.map(item=>item.name).join(', ')}} </dt>
                            <EditModal
                                @action="editField"
                                class="col-span-1 flex justify-end"
                            >
                                <div class="flex flex-col lg:flex-row gap-4">

                                    <MultiSelectObjectFilter
                                        class="w-full"
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

                <h2 class="text-2xl my-9 font-bold text-gray-900">{{ $t('i_pay_title') }}</h2>

                <div class="border border-gray-100">
                    <dl class="divide-y divide-gray-100">

                        <!-- Edit merchant id -->
                        <div class="bg-gray-100 px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('merchant_id') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.status }}</dt>
                            <EditModal
                                @action="editField"
                                class="col-span-1 flex justify-end"
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
                        <div class="bg-white px-4 py-6 grid grid-cols-12">
                            <dt class="col-span-12 md:col-span-5 text-base font-medium leading-6 text-gray-700">{{ $t('key_label') }}</dt>
                            <dt class="col-span-12 md:col-span-6 text-base font-medium leading-6 text-gray-700">{{ form.status }}</dt>
                            <EditModal
                                @action="editField"
                                class="col-span-1 flex justify-end"
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
    onMounted(() => {
        console.log(form);
    })

    const editField = () => {
        form.put(route('admin.ong.update', form.id), {
            preserveScroll: true,
            onSuccess: () => {},
            onError: () => {},
        });
    }
</script>
