<template>
    <div>
        <button id="volunteer-active-modal" @click="open = !open" :class="triggerModalClasses">
            {{ triggerModalText }}
        </button>

        <Teleport to="body" :show="open">
            <TransitionRoot as="template" :show="open">
                <Dialog as="div" class="relative z-101" @close="open = false">
                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="ease-in duration-200"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" />
                    </TransitionChild>

                    <div class="fixed inset-0 z-50 overflow-y-auto">
                        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                            <TransitionChild
                                as="template"
                                enter="ease-out duration-300"
                                enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                enter-to="opacity-100 translate-y-0 sm:scale-100"
                                leave="ease-in duration-200"
                                leave-from="opacity-100 translate-y-0 sm:scale-100"
                                leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            >
                                <DialogPanel
                                    class="relative px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                                >
                                    <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                                        <button
                                            type="button"
                                            class="text-gray-400 bg-white rounded-md hover:text-gray-500"
                                            @click="open = false"
                                        >
                                            <span class="sr-only">Close</span>
                                            <XIcon class="w-6 h-6" aria-hidden="true" />
                                        </button>
                                    </div>
                                    <div class="sm:flex sm:items-start">
                                        <div class="w-full mt-6">
                                            <div>
                                                <h3 class="text-xl font-semibold text-center text-gray-800">
                                                    {{ $t('register_as_volunteer') }}
                                                </h3>
                                                <h3
                                                    v-if="data.name"
                                                    class="text-xl font-semibold text-center text-primary-500"
                                                >
                                                    {{ data.name }}
                                                </h3>
                                                <p class="my-4 text-sm text-gray-500">
                                                    {{ $t('voluntier_form_intro') }}
                                                </p>
                                                <p v-if="$page.props.auth.user" class="my-4 text-sm text-gray-500">
                                                    {{ $t('logged_as') }} {{ $page.props.auth.user.name }} ({{
                                                        $page.props.auth.user.email
                                                    }})
                                                </p>
                                            </div>
                                            <form class="space-y-4" @submit.prevent="volunteerForm">
                                                <!-- Name -->
                                                <Input
                                                    v-if="!$page.props.auth.user"
                                                    class="w-full"
                                                    :label="$t('name_last_name')"
                                                    color="gray-700"
                                                    id="name"
                                                    type="text"
                                                    v-model="form.name"
                                                    :error="form.errors.name"
                                                />

                                                <!-- Email -->
                                                <Input
                                                    v-if="!$page.props.auth.user"
                                                    class="w-full"
                                                    :label="$t('email')"
                                                    color="gray-700"
                                                    id="email"
                                                    type="email"
                                                    v-model="form.email"
                                                    :error="form.errors.email"
                                                />

                                                <!-- Phone -->
                                                <Input
                                                    v-if="!$page.props.auth.user"
                                                    class="w-full"
                                                    :label="$t('phone')"
                                                    placeholder=""
                                                    color="gray-700"
                                                    id="phone"
                                                    type="number"
                                                    v-model="form.phone"
                                                    :error="form.errors.phone"
                                                />

                                                <!-- Phone -->
                                                <Input
                                                    v-if="$page.props.auth.user"
                                                    class="w-full"
                                                    :label="$t('phone')"
                                                    placeholder=""
                                                    color="gray-700"
                                                    id="phone"
                                                    type="number"
                                                    v-model="form.phone"
                                                    :error="form.errors.phone"
                                                />

                                                <!-- Confirm -->
                                                <label v-if="!$page.props.auth.user" class="flex items-center">
                                                    <Checkbox name="confirm" v-model:checked="form.terms" />
                                                    <span class="ml-2 mr-1 text-sm text-gray-700">{{
                                                        $t('i_agree')
                                                    }}</span>
                                                    <Link :href="route('terms')" class="text-sm text-primary-500"
                                                        >{{ $t('terms_link') }}<span class="text-red-500">*</span></Link
                                                    >

                                                    <!-- Error -->
                                                    <p v-show="form.errors.terms" class="mt-2 text-sm text-red-600">
                                                        {{ form.errors.terms }}
                                                    </p>
                                                </label>

                                                <div
                                                    class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                                    role="alert"
                                                    v-show="successSubmit"
                                                >
                                                    <span class="font-medium">{{ $t('volunteer_form_success') }}</span>
                                                </div>
                                                <!-- Actions -->
                                                <div class="w-full pt-6">
                                                    <PrimaryButton
                                                        type="submit"
                                                        class="w-full"
                                                        :label="$t('register_as_volunteer')"
                                                    />

                                                    <div v-if="!$page.props.auth.user">
                                                        <p class="py-1 text-sm font-medium text-center text-gray-900">
                                                            {{ $t('or') }}
                                                        </p>

                                                        <Link
                                                            :href="route('login')"
                                                            class="rounded-md block text-center bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                                        >
                                                            {{ $t('login_bb') }}
                                                        </Link>

                                                        <p class="pt-2 text-sm font-medium text-center text-gray-900">
                                                            {{ $t('join_easy') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>
        </Teleport>

        <Modal id="project-expired" class="hidden">
            <div class="w-full mt-6">
                <h3 class="text-xl font-semibold text-center text-gray-800">{{ $t('donation_period_ended') }}</h3>
                <h3 class="text-xl font-semibold text-center text-primary-500">{{ $t('donate_to_other_projects') }}</h3>
                <Link
                    :href="route('projects')"
                    class="rounded-md block mt-6 text-center bg-primary-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm"
                >
                    {{ $t('see_other_projects') }}
                </Link>
            </div>
        </Modal>
    </div>
</template>

<script setup>
    /** Import from vue */
    import { ref, computed } from 'vue';

    /** Import from inertia. */
    import { Link, useForm, usePage } from '@inertiajs/vue3';

    /** Import plugins. */
    import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
    import { XIcon } from '@heroicons/vue/outline';

    /** Import components. */
    import Modal from '@/Components/modals/Modal.vue';
    import Input from '@/Components/form/Input.vue';
    import Checkbox from '@/Components/form/Checkbox.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    /** Component props. */
    const props = defineProps({
        triggerModalText: String,
        triggerModalClasses: String,
        data: [Object, Array, String, Number],
        postUrl: String,
    });

    /** Local data. */
    const open = ref(false);

    /** Initialize inertia from Object. */
    const form = useForm({
        name: '',
        email: '',
        phone: '',
        terms: false,
    });

    /** Trigger modal */
    const triggerClick = (id) => document.getElementById(`${id}`).click();

    /** Check donation period. */
    const projectExpired = computed(() => {
        if (new Date() > new Date(props.data.period_end)) {
            return true;
        }

        return false;
    });

    let successSubmit = ref(false);

    /** Volunteer action */
    const volunteerForm = () => {
        /** Check if project is active. */
        if (projectExpired.value) {
            open.value = false;
            triggerClick('project-expired');

            return;
        }

        let user = usePage().props?.auth && usePage().props?.auth?.user ? usePage().props.auth.user : null;

        if (user) {
            form.name = `${usePage().props.auth.user.name} `;
            form.email = usePage().props.auth.user.email;
            form.terms = true;
        }
        form.post(props.postUrl, {
            onSuccess: () => {
                successSubmit.value = true;
            },
            onError: (error) => {
                console.log(error);
            },
        });
    };
</script>
