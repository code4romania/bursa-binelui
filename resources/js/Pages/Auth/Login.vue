<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <!-- Auth template. -->
        <Auth :content="content">
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
                        {{  $t('password_forgoten') }}
                    </Link>

                </div>

                <!-- Action -->
                <div class="grid grid-cols-2 gap-4 mt-6">

                    <!-- Log in button -->
                    <PrimaryButton
                        background="primary-500"
                        hover="primary-400"
                        color="white"
                        class="col-span-2 md:col-span-1"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        {{ $t('log_in') }}
                    </PrimaryButton>


                    <SecondaryButton
                        class="col-span-2 md:col-span-1 w-full flex items-center justify-center flex-1 gap-x-2 py-2.5"
                        @click="googleLogin"
                    >
                        <SvgLoader name="google" />
                        {{ $t("google_login") }}
                    </SecondaryButton>
                </div>
            </form>
        </Auth>
    </PageLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { Head, Link, useForm } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Auth from '@/Components/templates/Auth.vue';
    import Input from '@/Components/form/Input.vue';
    import Checkbox from '@/Components/form/Checkbox.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';

    /** Component props. */
    defineProps({
        canResetPassword: { type: Boolean },
        status: {type: String }
    });

    /** Page content. */
    const content = {
        title: "Intră în cont",
        description: "Nu ai cont pe Bursa Binelui?",
        link: {
            text: "Creează cont nou",
            href: "register"
        }
    }

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
        });
    };

    /** Goolge login */
    const googleLogin = () => {
        /** TODO
         * Method for login with google
         */
    }
</script>
