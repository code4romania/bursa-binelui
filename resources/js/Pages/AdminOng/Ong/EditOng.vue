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

                <div class="mt-6 border border-gray-100">
                    <dl class="divide-y divide-gray-100">
                        <!-- Edit organization name -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                                {{ $t('organization_name_label') }}
                            </dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                                {{ organization.name }}
                            </dt>
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
                        </div>

                        <!-- Edit organization cif -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-white">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                                {{ $t('cif_label') }}
                            </dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                                {{ organization.cif }}
                            </dt>
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
                        </div>

                        <!-- Edit organization image -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                                {{ $t('organization_logo_label') }}
                            </dt>
                            <dt
                                class="flex items-center col-span-12 gap-6 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                            >
                                <img class="flex-shrink-0 w-32 h-32" :src="organization.cover_image" alt="" />
                                <div>
                                    <EditModal @action="editField('cover_image')" :text="$t('change_image_label')">
                                        <FileInput
                                            :label="$t('upload_logo')"
                                            @upload="handleFileChange"
                                            :form="organization.cover_image"
                                        />
                                    </EditModal>

                                    <ModalAction
                                        triggerModalClasses="block text-sm font-medium leadin-5 text-blue-500"
                                        :triggerModalText="$t('delete_image_label')"
                                        :cancelModalText="$t('cancel')"
                                        :actionModalText="$t('delete')"
                                        :title="$t('confirm')"
                                        :body="`${$t('confirm_delete_image_text')}`"
                                        :actionRoute="route('organization.remove_cover_image', organization.id)"
                                        :data="organization"
                                    />
                                </div>
                            </dt>
                        </div>

                        <!-- Edit organization description -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-white">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                                {{ $t('organization_description_label') }}
                            </dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                                {{ organization.description }}
                            </dt>
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
                        </div>

                        <!-- Edit activity domains -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                                {{ $t('organization_activity_label') }}
                            </dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                                {{ organization.activity_domains?.map((item) => item.name).join(', ') }}
                            </dt>
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
                        </div>

                        <!-- Edit activity domains -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-white">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                                {{ $t('status_document_label') }}
                            </dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                                <a
                                    :href="organization.statute_link"
                                    target="_blank"
                                    class="inline-flex justify-center rounded-md bg-primary-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-500 sm:col-start-2"
                                >
                                    {{ $t('open_statue') }}
                                </a>
                            </dt>
                            <EditModal
                                @action="editField('statute_link')"
                                @cancel="resetField('statute_link')"
                                class="flex justify-end col-span-1"
                            >
                                <Input
                                    class="w-full"
                                    :label="$t('status_document_label')"
                                    color="gray-700"
                                    id="status-document"
                                    type="text"
                                    v-model="organization.statute_link"
                                    :error="props.errors.statute_link"
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
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                                {{ $t('organization_accepts_volunteers_label') }}
                            </dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                                {{ organization.accepts_volunteers ? $t('yes') : $t('no') }}
                            </dt>

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
                                    <span class="ml-2 text-sm text-gray-700">{{
                                        $t('organization_accepts_volunteers_label')
                                    }}</span>

                                    <!-- Error -->
                                    <p v-show="props.errors.accepts_volunteers" class="mt-2 text-sm text-red-600">
                                        {{ props.errors.accepts_volunteers }}
                                    </p>
                                </label>
                            </EditModal>
                        </div>

                        <!-- Edit why volunteer -->
                        <div class="grid grid-cols-12 gap-6 px-4 py-6 bg-white">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                                {{ $t('organization_why_volunteer_label') }}
                            </dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                                {{ organization.why_volunteer }}
                            </dt>
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
                        </div>
                    </dl>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 my-9">{{ $t('organization_contact') }}</h2>

                <div class="border border-gray-100">
                    <dl class="divide-y divide-gray-100">
                        <!-- Edit organizaton website -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                                {{ $t('organization_website_label') }}
                            </dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                                {{ organization.website }}
                            </dt>
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
                        </div>

                        <!-- Edit organizaton email -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-white">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                                {{ $t('organization_email_label') }}
                            </dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                                {{ organization.contact_email }}
                            </dt>
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
                        </div>

                        <!-- Edit organizaton phone -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                                {{ $t('organization_phone_label') }}
                            </dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                                {{ organization.contact_phone }}
                            </dt>
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
                        </div>

                        <!-- Edit organizaton contact person -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-white">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                                {{ $t('organization_contact_person_label') }}
                            </dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                                {{ organization.contact_person }}
                            </dt>
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
                        </div>

                        <!-- Edit organizaton address -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                                {{ $t('organization_address_label') }}
                            </dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                                {{ organization.street_address }},
                                {{ originalOrganization.counties?.map((item) => item.name).join(', ') }}
                            </dt>
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
                        </div>
                    </dl>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 my-9">{{ $t('i_pay_title') }}</h2>

                <div class="border border-gray-100">
                    <dl class="divide-y divide-gray-100">
                        <!-- Edit merchant id -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                                {{ $t('merchant_id') }}
                            </dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                                {{ organization.status }}
                            </dt>
                            <EditModal
                                @action="editField('status')"
                                @cancel="resetField('status')"
                                class="flex justify-end col-span-1"
                            >
                                <Input
                                    class="w-full"
                                    :label="$t('merchant_id')"
                                    color="gray-700"
                                    id="merchant"
                                    type="text"
                                    v-model="organization.status"
                                    :error="props.errors.status"
                                />
                            </EditModal>
                        </div>

                        <!-- Edit key -->
                        <div class="grid grid-cols-12 px-4 py-6 bg-white">
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5">
                                {{ $t('key_label') }}
                            </dt>
                            <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                                {{ organization.status }}
                            </dt>
                            <EditModal
                                @action="editField('status')"
                                @cancel="resetField('status')"
                                class="flex justify-end col-span-1"
                            >
                                <Input
                                    class="w-full"
                                    :label="$t('key_label')"
                                    color="gray-700"
                                    id="key-label"
                                    type="text"
                                    v-model="organization.status"
                                    :error="props.errors.status"
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
    import { ref, computed } from 'vue';
    /** Import from inertia. */
    import { Head, useForm } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Dashboard from '@/Components/templates/Dashboard.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Alert from '@/Components/Alert.vue';
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
    });

    const organization = ref(props.organization);
    const originalOrganization = computed(() => props.organization);
    const resetField = (field) => {
        organization.value[field] = originalOrganization.value[field];
    };

    const editField = (field) => {
        let data = {[field]: organization.value[field]};
        let tmpForm = useForm(data)

        console.log(field)
        console.log(tmpForm)



        tmpForm.post(route('admin.ong.update', organization.value.id), {
            preserveScroll: true,
            onSuccess: (response) => {
                organization.value.cover_image = response.props.organization.cover_image;
                console.log(organization)
            },
        });
    };

    const handleFileChange = (file) => {
        organization.value.cover_image = file;
    };
</script>
