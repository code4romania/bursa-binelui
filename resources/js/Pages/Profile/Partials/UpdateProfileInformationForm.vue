<template>
    <section>

        <header class="flex items-center gap-4 mt-12">
            <SvgLoader name="user" class="fill-white"/>
            <h2 class="text-2xl font-bold text-gray-900">{{ $t('account_settings') }}</h2>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="space-y-6 mt-11">

            <!-- Name -->
            <Input
                :label="$t('name_last_name')"
                id="name"
                type="text"
                v-model="form.name"
                :isRequired="true"
                :error="form.errors.name"
            />

            <!-- Email -->
            <Input
                :label="$t('email')"
                id="email"
                type="email"
                v-model="form.email"
                :isRequired="true"
                :error="form.errors.email"
            />

            <!-- Phone -->
            <Input
                :label="$t('phone')"
                id="phone"
                type="number"
                pattern="[0-9]{10}"
                v-model="form.phone"
                :isRequired="true"
                :error="form.errors.phone"
                :min="0"
                :maxlength="10"
            >
                <p class="pt-1 text-sm text-gray-500">{{ $t('phone_input_info') }}</p>
            </Input>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    {{ $t('unverified_email') }}
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        {{ $t('reverify_email') }}
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    {{ $t('verification_email') }}
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-4">

                <!-- Cancel button -->
                <SecondaryButton
                    class="py-2.5"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ $t('cancel') }}
                </SecondaryButton>

                <!-- Save button -->
                <PrimaryButton
                    background="primary-500"
                    hover="primary-400"
                    color="white"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ $t('save') }}
                </PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">{{ $t('saved') }}</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<script setup>
    /** Import from inertia. */
    import { Link, useForm, usePage } from '@inertiajs/vue3';

    /** Import components. */
    import Input from '@/Components/form/Input.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';

    /** Component props. */
    defineProps({
        mustVerifyEmail: {
            type: Boolean,
        },
        status: {
            type: String,
        },
    });

    /** Get user. */
    const user = usePage().props.auth.user;

    /** Form variables. */
    const form = useForm({
        name: user.name,
        email: user.email,
        phone: user.phone,
    });
</script>
