<template>
    <div>
        <button id="donate-active-modal" @click="open = !open" :class="triggerModalClasses">
            {{ triggerModalText }}
        </button>

        <Teleport to="body">
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
                                                    {{ $t('donate_to_project') }}
                                                </h3>
                                                <h3
                                                    v-if="data.name"
                                                    class="text-xl font-semibold text-center text-primary-500"
                                                >
                                                    {{ data.name }}
                                                </h3>
                                                <p class="my-4 text-sm text-gray-500">{{ $t('donate_form_intro') }}</p>
                                                <p v-if="$page.props.auth.user" class="my-4 text-sm text-gray-500">
                                                    {{ $t('logged_as') }} {{ $page.props.auth.user.name }} ({{
                                                        $page.props.auth.user.email
                                                    }})
                                                </p>
                                            </div>

                                            {{}}

                                            <form class="space-y-4" @submit.prevent="donate">
                                                <!-- Name -->
                                                <Input
                                                    v-if="!$page.props.auth.user"
                                                    class="w-full"
                                                    :label="$t('name_last_name')"
                                                    color="gray-700"
                                                    id="name"
                                                    type="text"
                                                    v-model="guestForm.name"
                                                    :error="guestForm.errors.name"
                                                />

                                                <!-- Email -->
                                                <Input
                                                    v-if="!$page.props.auth.user"
                                                    class="w-full"
                                                    :label="$t('email')"
                                                    color="gray-700"
                                                    id="email"
                                                    type="email"
                                                    v-model="guestForm.email"
                                                    :error="guestForm.errors.email"
                                                />

                                                <!-- Amount -->
                                                <Input
                                                    v-if="!$page.props.auth.user"
                                                    class="w-full"
                                                    :label="$t('donation_value')"
                                                    placeholder="0 RON"
                                                    color="gray-700"
                                                    id="amount"
                                                    type="number"
                                                    v-model="guestForm.amount"
                                                    :error="guestForm.errors.amount"
                                                />

                                                <!-- Amount -->
                                                <Input
                                                    v-if="$page.props.auth.user"
                                                    class="w-full"
                                                    :label="$t('donation_value')"
                                                    placeholder="0 RON"
                                                    color="gray-700"
                                                    id="amount"
                                                    type="number"
                                                    v-model="authForm.amount"
                                                    :error="authForm.errors.amount"
                                                />

                                                <!-- Confirm -->
                                                <label v-if="!$page.props.auth.user" class="flex items-center">
                                                    <Checkbox name="confirm" v-model:checked="guestForm.terms" />
                                                    <span class="ml-2 mr-1 text-sm text-gray-700">{{
                                                        $t('i_agree')
                                                    }}</span>
                                                    <Link :href="route('terms')" class="text-sm text-primary-500"
                                                        >{{ $t('terms_link') }}<span class="text-red-500">*</span></Link
                                                    >

                                                    <!-- Error -->
                                                    <p
                                                        v-show="guestForm.errors.terms"
                                                        class="mt-2 text-sm text-red-600"
                                                    >
                                                        {{ guestForm.errors.terms }}
                                                    </p>
                                                </label>

                                                <!-- Actions -->
                                                <div class="w-full pt-6">
                                                    <PrimaryButton
                                                        background="primary-500"
                                                        hover="primary-400"
                                                        color="white"
                                                        class="w-full"
                                                    >
                                                        {{ $t('proceed_to_payment') }}
                                                    </PrimaryButton>

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
                                                            {{ $t('donate_for_reward') }}
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
    </div>
</template>

<script setup>
    /** Import from vue */
    import { ref } from 'vue';

    /** Import from inertia. */
    import { Link, useForm, usePage } from '@inertiajs/vue3';

    /** Import plugins. */
    import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
    import { XIcon } from '@heroicons/vue/outline';

    /** Import components. */
    import Input from '@/Components/form/Input.vue';
    import Checkbox from '@/Components/form/Checkbox.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    /** Component props. */
    const props = defineProps({
        triggerModalText: String,
        triggerModalClasses: String,
        data: [Object, Array, String, Number],
    });

    /** Local data. */
    const open = ref(false);

    /** Initialize inertia from Object. */
    const guestForm = useForm({
        name: '',
        email: '',
        amount: '',
        terms: false,
    });

    /** Initialize inertia from Object. */
    const authForm = useForm({
        amount: '',
    });

    /** Donate action */
    const donate = () => {
        console.log(guestForm);

        /** Trigger donate post method. */
        if (!usePage().props.auth.user) {
            guestForm.post(route('project.donation', props.data.slug), {
                onSuccess: () => (open.value = false),
                onError: (errors) => {
                    console.log('error', errors);
                },
                onFinish: () => guestForm.reset(),
            });
        } else {
            // authForm.post(route('ruta', data.id), {
            //     onFinish: () => form.reset(),
            // });
        }
    };
</script>
