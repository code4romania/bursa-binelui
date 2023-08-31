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
                        <SvgLoader class="shrink-0" name="menu" />
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $t('ong_description') }}</h2>
                </header>

                <!-- Alert -->
                <Alert
                    class="fixed z-50 right-10 top-10 w-96"
                    :type="$page.props.flash.message ? 'error' : $page.props.flash?.success_message ? 'success' : false"
                    :message="$page.props.flash?.success_message || $page.props.flash?.error_message"
                    @emptyFlash="Object.assign(flash, { success_message: '', error_message: '' })"
                />

                <dl class="mt-6 border border-gray-100 divide-y divide-gray-100">
                    <!-- Edit organization name -->
                    <Field
                        :label="$t('organization_name_label')"
                        :hasPendingChanges="props.changes.includes('name')"
                        alt
                    >
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
                                    :error="props.errors.name"
                                />
                            </EditModal>
                        </template>
                    </Field>

                    <!-- Edit organization cif -->
                    <Field :label="$t('cif_label')" :hasPendingChanges="props.changes.includes('cif')">
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
                                    :error="props.errors.cif"
                                />
                            </EditModal>
                        </template>
                    </Field>

                    <!-- Edit organization image -->
                    <Field
                        :label="$t('organization_logo_label')"
                        :hasPendingChanges="props.changes.includes('cover_image')"
                        alt
                    >
                        <template #value>
                            <div
                                class="flex items-center col-span-12 gap-6 text-base font-medium leading-6 text-gray-700"
                            >
                                <img class="object-contain w-32 h-32 shrink-0" :src="organization.cover_image" alt="" />

                                <div>
                                    <EditModal @action="editField('cover_image')" :text="$t('change_image_label')">
                                        <FileInput
                                            :label="$t('upload_logo')"
                                            @upload="(file) => (organization.cover_image = file)"
                                            :form="organization.cover_image"
                                            accept="image/png, image/jpeg"
                                            previewable
                                        />
                                    </EditModal>

                                    <ModalAction
                                        triggerModalClasses="block text-sm font-medium leadin-5 text-red-600"
                                        :triggerModalText="$t('delete_image_label')"
                                        :cancelModalText="$t('cancel')"
                                        :actionModalText="$t('delete')"
                                        :title="$t('confirm')"
                                        :body="`${$t('confirm_delete_image_text')}`"
                                        :actionRoute="route('organization.remove_cover_image', organization.id)"
                                        :data="organization"
                                    />
                                </div>
                            </div>
                        </template>
                    </Field>

                    <!-- Edit organization description -->
                    <Field
                        :label="$t('organization_description_label')"
                        :hasPendingChanges="props.changes.includes('description')"
                    >
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
                                    :error="props.errors.description"
                                />
                            </EditModal>
                        </template>
                    </Field>

                    <!-- Edit activity domains -->
                    <Field
                        :label="$t('organization_activity_label')"
                        :hasPendingChanges="props.changes.includes('activity_domains')"
                        alt
                    >
                        <template #value>
                            {{ organization.activity_domains?.map((item) => item.name).join(', ') }}
                        </template>

                        <template #action>
                            <EditModal
                                @action="editField('activity_domains')"
                                @cancel="resetField('activity_domains')"
                                class="flex justify-end col-span-1"
                            >
                                <SelectMultiple
                                    class="w-full z-101"
                                    :label="$t('organization_activity_label')"
                                    type="singleValue"
                                    :options="activity_domains"
                                    v-model="organization.activity_domains"
                                    :error="props.errors.activity_domains"
                                />
                            </EditModal>
                        </template>
                    </Field>

                    <!-- Edit statute -->
                    <Field :label="$t('status_document_label')" :hasPendingChanges="props.changes.includes('statute')">
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
                                @action="editField('statute_link')"
                                @cancel="resetField('statute_link')"
                                class="flex justify-end col-span-1"
                            >
                                <FileInput
                                    :label="$t('status_document_label')"
                                    @upload="
                                        (file) => {
                                            console.log(file);
                                        }
                                    "
                                    :form="organization.statute"
                                />
                            </EditModal>
                        </template>
                    </Field>

                    <!-- Edit counties -->
                    <Field :label="$t('counties_label')" :hasPendingChanges="props.changes.includes('counties')" alt>
                        <template #value>
                            {{ organization.counties?.map((item) => item.name).join(', ') }}
                        </template>

                        <template #action>
                            <EditModal
                                @action="editField('counties')"
                                @cancel="resetField('counties')"
                                class="flex justify-end col-span-1"
                            >
                                <SelectMultiple
                                    class="w-full z-101"
                                    :label="$t('counties_label')"
                                    type="singleValue"
                                    :options="counties"
                                    v-model="organization.counties"
                                    :error="props.errors.counties"
                                />
                            </EditModal>
                        </template>
                    </Field>
                </dl>

                <h2 class="text-2xl font-bold text-gray-900 my-9">{{ $t('volunteer') }}</h2>

                <dl class="border border-gray-100 divide-y divide-gray-100">
                    <!-- Edit accepts voluntiers -->
                    <Field
                        :label="$t('organization_accepts_volunteers_label')"
                        :hasPendingChanges="props.changes.includes('accepts_volunteers')"
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
                                    <Checkbox
                                        name="accepts_volunteers"
                                        v-model:checked="organization.accepts_volunteers"
                                    />

                                    <span
                                        class="ml-2 text-sm text-gray-700"
                                        v-text="$t('organization_accepts_volunteers_label')"
                                    />

                                    <!-- Error -->
                                    <p v-show="props.errors.accepts_volunteers" class="mt-2 text-sm text-red-600">
                                        {{ props.errors.accepts_volunteers }}
                                    </p>
                                </label>
                            </EditModal>
                        </template>
                    </Field>

                    <!-- Edit why volunteer -->
                    <Field
                        :label="$t('organization_why_volunteer_label')"
                        :hasPendingChanges="props.changes.includes('why_volunteer')"
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
                                    :error="props.errors.why_volunteer"
                                />
                            </EditModal>
                        </template>
                    </Field>
                </dl>

                <h2 class="text-2xl font-bold text-gray-900 my-9">{{ $t('organization_contact') }}</h2>
                <dl class="border border-gray-100 divide-y divide-gray-100">
                    <!-- Edit organizaton website -->
                    <Field
                        :label="$t('organization_website_label')"
                        :hasPendingChanges="props.changes.includes('website')"
                        alt
                    >
                        <template #value>
                            {{ organization.website }}
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
                                    :error="props.errors.website"
                                />
                            </EditModal>
                        </template>
                    </Field>

                    <!-- Edit organizaton email -->
                    <Field
                        :label="$t('organization_email_label')"
                        :hasPendingChanges="props.changes.includes('contact_email')"
                    >
                        <template #value>
                            {{ organization.contact_email }}
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
                                    :error="props.errors.contact_email"
                                />
                            </EditModal>
                        </template>
                    </Field>

                    <!-- Edit organizaton phone -->
                    <Field
                        :label="$t('organization_phone_label')"
                        :hasPendingChanges="props.changes.includes('contact_phone')"
                        alt
                    >
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
                                    :error="props.errors.contact_phone"
                                />
                            </EditModal>
                        </template>
                    </Field>

                    <!-- Edit organizaton contact person -->

                    <Field
                        :label="$t('organization_contact_person_label')"
                        :hasPendingChanges="props.changes.includes('contact_person')"
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
                                    :error="props.errors.contact_person"
                                />
                            </EditModal>
                        </template>
                    </Field>

                    <!-- Edit organizaton address -->
                    <Field
                        :label="$t('organization_address_label')"
                        :hasPendingChanges="props.changes.includes('street_address')"
                        alt
                    >
                        <template #value>
                            {{ organization.street_address }},
                            {{ originalOrganization.counties?.map((item) => item.name).join(', ') }}
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
                                    <SelectMultiple
                                        class="w-full z-101"
                                        :label="$t('counties_label')"
                                        :options="counties"
                                        type="object"
                                        v-model="organization.counties"
                                        v-if="!organization.is_national"
                                        :error="props.errors.counties"
                                    />
                                </div>

                                <Input
                                    class="w-full mt-4"
                                    :label="$t('street_address_label')"
                                    color="gray-700"
                                    id="street-addres"
                                    type="text"
                                    v-model="organization.street_address"
                                    :error="props.errors.street_address"
                                />
                            </EditModal>
                        </template>
                    </Field>
                </dl>

                <h2 class="text-2xl font-bold text-gray-900 my-9">{{ $t('i_pay_title') }}</h2>

                <dl class="border border-gray-100 divide-y divide-gray-100">
                    <!-- Merchant id -->
                    <Field :label="$t('merchant_id')" alt>
                        <template #value>
                            {{ organization.merchant_id }}
                        </template>
                    </Field>

                    <!-- Merchant key -->
                    <Field :label="$t('key_label')">
                        <template #value>
                            {{ organization.merchant_key }}
                        </template>
                    </Field>
                </dl>
            </div>
        </Dashboard>
    </PageLayout>
</template>

<script setup>
    import { ref, computed } from 'vue';
    /** Import from inertia. */
    import { Head, useForm } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Dashboard from '@/Components/templates/Dashboard.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Alert from '@/Components/Alert.vue';
    import Field from '@/Components/Field.vue';
    import EditModal from '@/Components/modals/EditModal.vue';
    import Input from '@/Components/form/Input.vue';
    import Textarea from '@/Components/form/Textarea.vue';
    import Checkbox from '@/Components/form/Checkbox.vue';
    import FileInput from '@/Components/form/FileInput.vue';
    import ModalAction from '@/Components/modals/ModalAction.vue';
    import SelectMultiple from '@/Components/form/SelectMultiple.vue';
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

    const organization = ref(props.organization);
    const originalOrganization = computed(() => props.organization);
    const resetField = (field) => {
        organization.value[field] = originalOrganization.value[field];
    };

    const editField = (field) => {
        let data = { [field]: organization.value[field] };
        let tmpForm = useForm(data);
        tmpForm.post(route('admin.ong.update', organization.value.id), {
            preserveScroll: true,
            onSuccess: (response) => {
                organization.value.cover_image = response.props.organization.cover_image;
                console.log(organization);
            },
        });
    };
</script>
