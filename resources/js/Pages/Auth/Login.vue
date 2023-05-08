<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <!-- Auth template. -->
        <Auth :content="content">
            <form class="space-y-4 mt-4" @submit.prevent="submit">

                <!-- Email. -->
                <Input
                    label="Email"
                    id="email"
                    type="email"
                    v-model="form.email"
                    :isRequired="true"
                    hasAutocomplete="username"
                    :error="form.errors.email"
                />

                <!-- Passowrd. -->
                <Input
                    label="Password"
                    id="password"
                    type="password"
                    v-model="form.password"
                    :isRequired="true"
                    hasAutocomplete="current-password"
                    :error="form.errors.password"
                />

                <div class="flex items-center justify-between">

                    <!-- Checkbox -->
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ml-2 text-sm text-gray-700">Remember me</span>
                    </label>

                    <!-- Reset password -->
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="underline text-sm text-turqoise-500 hover:text-turqoise-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-turqoise-500"
                    >
                        Forgot your password?
                    </Link>

                </div>

                <!-- Action -->
                <div class="mt-6 grid grid-cols-2 gap-4">

                    <!-- Log in button -->
                    <PrimaryButton
                        background="turqoise-500"
                        hover="turqoise-400"
                        color="white"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Intră în cont
                    </PrimaryButton>


                    <!-- <SecondaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Continuă cu Google
                    </SecondaryButton> -->
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
            href: "#"
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
</script>
