<template>
     <PageLayout>
        <!-- Inertia page head -->
        <Head title="Register" />

        <!-- Auth template. -->
        <Auth :content="content">
            <form class="space-y-4 mt-4" @submit.prevent="submit">
                <!-- Name -->
                <Input
                    :label="$t('name')"
                    id="name"
                    type="name"
                    v-model="form.name"
                    :isRequired="true"
                    color="gray-700"
                    hasAutocomplete="name"
                    :error="form.errors.name"
                />

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

                <!-- Confirm Passowrd. -->
                <Input
                    :label="$t('password')"
                    id="password_confirmation"
                    type="password"
                    v-model="form.password_confirmation"
                    :isRequired="true"
                    color="gray-700"
                    hasAutocomplete="new-password"
                    :error="form.errors.password_confirmation"
                />

                <div class="flex items-center justify-end mt-4">
                    <Link
                        :href="route('login')"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Already registered?
                    </Link>

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Register
                    </PrimaryButton>
                </div>
            </form>
        </Auth>
    </PageLayout>
</template>

<script setup>
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Auth from '@/Components/templates/Auth.vue';
    import Input from '@/Components/form/Input.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    /** Page content. */
    const content = {
        title: "Register",
        description: "Log in",
        link: {
            text: "lon in",
            href: "#"
        }
    }

    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const submit = () => {
        form.post(route('register'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };
</script>
