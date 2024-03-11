<template>
    <AuthLayout
        title="Intră în cont"
        :description="$t('no_account')"
        :actionText="$t('create_account')"
        :actionUrl="route('register')"
    >
        <form class="mt-4 space-y-4" @submit.prevent="submit">
            <!-- Email. -->
            <Input
                :label="$t('email')"
                id="email"
                type="email"
                v-model="form.email"
                :isRequired="true"
                color="gray-700"
                hasAutocomplete="username"
                :error="form.errors.email"
            />

            <!-- Passowrd. -->
            <Input
                :label="$t('password')"
                id="password"
                type="password"
                v-model="form.password"
                :isRequired="true"
                color="gray-700"
                hasAutocomplete="current-password"
                :error="form.errors.password"
            />

            <div class="flex items-center justify-between">
                <!-- Checkbox -->
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-700">{{ $t('remember_me') }}</span>
                </label>

                <!-- Reset password -->
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm underline rounded-md text-primary-500 hover:text-primary-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                    {{ $t('password_forgoten') }}
                </Link>
            </div>

            <!-- Action -->
            <div class="grid grid-cols-2 gap-4 mt-6">
                <!-- Log in button -->
                <PrimaryButton
                    type="submit"
                    class="col-span-2 md:col-span-1"
                    :disabled="form.processing"
                    :label="$t('log_in')"
                />
            </div>
        </form>
    </AuthLayout>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import route from '@/Helpers/useRoute';
    import AuthLayout from '@/Layouts/AuthLayout.vue';
    import Input from '@/Components/form/Input.vue';
    import Checkbox from '@/Components/form/Checkbox.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';

    /** Component props. */
    defineProps({
        canResetPassword: { type: Boolean },
        status: { type: String },
    });

    /** Form variables. */
    const form = useForm({
        email: '',
        password: '',
        remember: false,
    });

    /** Submit action. */
    const submit = () => {
        form.post(route('login'), {
            onFinish: () => form.reset('password'),
            replace: true,
        });
    };

    /** Goolge login */
    const googleLogin = () => {
        /** TODO
         * Method for login with google
         */
    };
</script>
