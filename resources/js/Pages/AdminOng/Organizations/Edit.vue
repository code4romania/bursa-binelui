<template>
    <DashboardLayout gridClass="gap-10">
        <Head :title="$t('administrate_link')" />

        <FieldSection>
            <!-- Edit organization name -->
            <Field :label="$t('organization_name_label')" :hasPendingChanges="changes.includes('name')" alt>
                <template #value>
                    {{ organization.name }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('name')"
                        @cancel="resetField('name')"
                        class="flex justify-end col-span-1"
                    >
                        <Input
                            class="w-full"
                            :label="$t('organization_name_label')"
                            color="gray-700"
                            id="organization-name"
                            type="text"
                            v-model="organization.name"
                            :error="errors.name"
                        />
                    </EditModal>
                </template>
            </Field>

            <!-- Edit organization cif -->
            <Field :label="$t('cif_label')" :hasPendingChanges="changes.includes('cif')">
                <template #value>
                    {{ organization.cif }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('cif')"
                        @cancel="resetField('cif')"
                        class="flex justify-end col-span-1"
                    >
                        <Input
                            class="w-full"
                            :label="$t('cif_label')"
                            color="gray-700"
                            id="organizationcif"
                            type="text"
                            v-model="organization.cif"
                            :error="errors.cif"
                        />
                    </EditModal>
                </template>
            </Field>

            <!-- Edit organization image -->
            <Field :label="$t('organization_logo_label')" :hasPendingChanges="changes.includes('logo')" alt>
                <template #value>
                    <img class="object-contain w-32 max-h-32 shrink-0" :src="organization.logo" alt="" />
                </template>

                <template #action>
                    <EditModal @action="editField('logo')" class="flex justify-end col-span-1">
                        <FileInput
                            :label="$t('upload_logo')"
                            @upload="(file) => (organization.logo = file)"
                            :form="organization.logo"
                            accept="image/png, image/jpeg"
                            previewable
                        />
                    </EditModal>
                </template>
            </Field>

            <!-- Edit organization description -->
            <Field :label="$t('organization_description_label')" :hasPendingChanges="changes.includes('description')">
                <template #value>
                    {{ organization.description }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('description')"
                        @cancel="resetField('description')"
                        class="flex justify-end col-span-1"
                    >
                        <Textarea
                            class="w-full"
                            :label="$t('organization_description_label')"
                            id="organization-description"
                            color="gray-700"
                            v-model="organization.description"
                            :error="errors.description"
                        />
                    </EditModal>
                </template>
            </Field>

            <!-- Edit activity domains -->
            <Field
                :label="$t('organization_activity_label')"
                :hasPendingChanges="changes.includes('activity_domains')"
                alt
            >
                <template #value>
                    {{ organization.activity_domain_names.join(', ') }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('activity_domains')"
                        @cancel="resetField('activity_domains')"
                        class="flex justify-end col-span-1"
                    >
                        <Select
                            :label="$t('organization_activity_label')"
                            type="singleValue"
                            :options="activity_domains"
                            v-model="organization.activity_domains"
                            :error="errors.activity_domains"
                            multiple
                        />
                    </EditModal>
                </template>
            </Field>

            <!-- Edit statute -->
            <Field :label="$t('status_document_label')" :hasPendingChanges="changes.includes('statute')">
                <template #value>
                    <a
                        v-if="organization.statute_link"
                        :href="organization.statute_link"
                        target="_blank"
                        class="inline-flex justify-center rounded-md bg-primary-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-500 sm:col-start-2"
                        v-text="$t('open_statue')"
                    />
                </template>

                <template #action>
                    <EditModal
                        @action="editField('statute')"
                        @cancel="resetField('statute')"
                        class="flex justify-end col-span-1"
                    >
                        <FileInput
                            :label="$t('status_document_label')"
                            @upload="(file) => (organization.statute = file)"
                        />
                    </EditModal>
                </template>
            </Field>

            <!-- Edit counties -->
            <Field :label="$t('counties_label')" :hasPendingChanges="changes.includes('counties')" alt>
                <template #value>
                    {{ organization.county_names.join(', ') }}
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
                            :options="counties"
                            v-model="organization.counties"
                            :error="errors.counties"
                            multiple
                        />
                    </EditModal>
                </template>
            </Field>
        </FieldSection>

        <FieldSection :title="$t('volunteer')">
            <!-- Edit accepts voluntiers -->
            <Field
                :label="$t('organization_accepts_volunteers')"
                :hasPendingChanges="changes.includes('accepts_volunteers')"
                alt
            >
                <template #value>
                    {{ organization.accepts_volunteers ? $t('yes') : $t('no') }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('accepts_volunteers')"
                        @cancel="resetField('accepts_volunteers')"
                        class="flex justify-end col-span-1"
                    >
                        <label class="flex items-center">
                            <Checkbox name="accepts_volunteers" v-model:checked="organization.accepts_volunteers" />

                            <span class="ml-2 text-sm text-gray-700" v-text="$t('organization_accepts_volunteers')" />

                            <!-- Error -->
                            <p v-show="errors.accepts_volunteers" class="mt-2 text-sm text-red-600">
                                {{ errors.accepts_volunteers }}
                            </p>
                        </label>
                    </EditModal>
                </template>
            </Field>

            <!-- Edit why volunteer -->
            <Field
                :label="$t('organization_why_volunteer_label')"
                :hasPendingChanges="changes.includes('why_volunteer')"
            >
                <template #value>
                    {{ organization.why_volunteer }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('why_volunteer')"
                        @cancel="resetField('why_volunteer')"
                        class="flex justify-end col-span-1"
                    >
                        <Textarea
                            class="w-full"
                            :label="$t('organization_why_volunteer_label')"
                            id="organization-volunteer"
                            color="gray-700"
                            v-model="organization.why_volunteer"
                            :error="errors.why_volunteer"
                        />
                    </EditModal>
                </template>
            </Field>
        </FieldSection>

        <FieldSection :title="$t('organization_contact')">
            <!-- Edit organizaton website -->
            <Field :label="$t('organization_website_label')" :hasPendingChanges="changes.includes('website')" alt>
                <template #value>
                    <a
                        href="{{ organization.website }}"
                        target="_blank"
                        rel="noopener noreferer"
                        class="hover:underline text-primary-600"
                        v-text="organization.website"
                    />
                </template>

                <template #action>
                    <EditModal
                        @action="editField('website')"
                        @cancel="resetField('website')"
                        class="flex justify-end col-span-1"
                    >
                        <Input
                            class="w-full"
                            :label="$t('organization_website_label')"
                            color="gray-700"
                            id="website"
                            type="text"
                            v-model="organization.website"
                            :error="errors.website"
                        />
                    </EditModal>
                </template>
            </Field>

            <!-- Edit organizaton email -->
            <Field :label="$t('organization_email_label')" :hasPendingChanges="changes.includes('contact_email')">
                <template #value>
                    <a
                        href="mailto:{{ organization.contact_email }}"
                        target="_blank"
                        rel="noopener noreferer"
                        class="hover:underline text-primary-600"
                        v-text="organization.contact_email"
                    />
                </template>

                <template #action>
                    <EditModal
                        @action="editField('contact_email')"
                        @cancel="resetField('contact_email')"
                        class="flex justify-end col-span-1"
                    >
                        <Input
                            class="w-full"
                            :label="$t('organization_email_label')"
                            color="gray-700"
                            id="email"
                            type="email"
                            v-model="organization.contact_email"
                            :error="errors.contact_email"
                        />
                    </EditModal>
                </template>
            </Field>

            <!-- Edit organizaton phone -->
            <Field :label="$t('organization_phone_label')" :hasPendingChanges="changes.includes('contact_phone')" alt>
                <template #value>
                    {{ organization.contact_phone }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('contact_phone')"
                        @cancel="resetField('contact_phone')"
                        class="flex justify-end col-span-1"
                    >
                        <Input
                            class="w-full"
                            :label="$t('organization_phone_label')"
                            color="gray-700"
                            id="phone"
                            type="text"
                            v-model="organization.contact_phone"
                            :error="errors.contact_phone"
                        />
                    </EditModal>
                </template>
            </Field>

            <!-- Edit organizaton contact person -->

            <Field
                :label="$t('organization_contact_person_label')"
                :hasPendingChanges="changes.includes('contact_person')"
            >
                <template #value>
                    {{ organization.contact_person }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('contact_person')"
                        @cancel="resetField('contact_person')"
                        class="flex justify-end col-span-1"
                    >
                        <Input
                            class="w-full"
                            :label="$t('organization_contact_person_label')"
                            color="gray-700"
                            id="contact-person"
                            type="text"
                            v-model="organization.contact_person"
                            :error="errors.contact_person"
                        />
                    </EditModal>
                </template>
            </Field>

            <!-- Edit organizaton address -->
            <Field
                :label="$t('organization_address_label')"
                :hasPendingChanges="changes.includes('street_address')"
                alt
            >
                <template #value>
                    {{ organization.street_address }},
                    {{ originalOrganization.county_names.join(', ') }}
                </template>

                <template #action>
                    <EditModal
                        @action="editField('counties')"
                        @cancel="
                            organization.counties = originalOrganization.counties;
                            organization.street_address = originalOrganization.street_address;
                        "
                        class="flex justify-end col-span-1"
                    >
                        <div class="flex flex-col gap-4 lg:flex-row">
                            <Select
                                :label="$t('counties_label')"
                                :options="counties"
                                type="object"
                                v-model="organization.counties"
                                v-if="!organization.is_national"
                                :error="errors.counties"
                                multiple
                            />
                        </div>

                        <Input
                            class="w-full mt-4"
                            :label="$t('street_address_label')"
                            color="gray-700"
                            id="street-addres"
                            type="text"
                            v-model="organization.street_address"
                            :error="errors.street_address"
                        />
                    </EditModal>
                </template>
            </Field>
        </FieldSection>

        <FieldSection :title="$t('payment_gateway_data')">
            <!-- Merchant id -->
            <Field :label="$t('merchant_id')" alt>
                <template #value>
                    {{ organization.eu_platesc_merchant_id ? $t('yes') : $t('no') }}
                </template>
            </Field>

            <!-- Merchant key -->
            <Field :label="$t('key_label')">
                <template #value>
                    {{ organization.eu_platesc_private_key ? $t('yes') : $t('no') }}
                </template>
            </Field>
        </FieldSection>
    </DashboardLayout>
</template>

<script setup>
    import { ref, computed } from 'vue';
    import { router, useForm } from '@inertiajs/vue3';
    import route from '@/Helpers/useRoute';
    import Head from '@/Components/Head.vue';
    import DashboardLayout from '@/Layouts/DashboardLayout.vue';
    import Title from '@/Components/Title.vue';
    import Alert from '@/Components/Alert.vue';
    import FieldSection from '@/Components/FieldSection.vue';
    import Field from '@/Components/Field.vue';
    import EditModal from '@/Components/modals/EditModal.vue';
    import Input from '@/Components/form/Input.vue';
    import Textarea from '@/Components/form/Textarea.vue';
    import Checkbox from '@/Components/form/Checkbox.vue';
    import FileInput from '@/Components/form/FileInput.vue';
    import ModalAction from '@/Components/modals/ModalAction.vue';
    import Select from '@/Components/form/Select.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    /** Page props. */
    const props = defineProps({
        errors: Object,
        organization: Object,
        activity_domains: Array,
        counties: Array,
        flash: Object,
        changes: Array,
    });

    const originalOrganization = computed(() => props.organization);
    const resetField = (field) => {
        router.reload({
            preserveScroll: true,
            only: ['organization'],
        });
    };

    const editField = (field) => {
        const form = useForm({
            [field]: props.organization[field],
        });

        form.post(route('dashboard.organization.update'), {
            preserveScroll: true,
        });
    };
</script>
