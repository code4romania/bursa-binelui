<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('header_confirm_password')" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <!-- Auth template. -->
        <Auth :content="content">
            <div class="mb-4 text-sm text-gray-600">
                {{ $t('confirm_password_info') }}
            </div>

            <form class="mt-4 space-y-4" @submit.prevent="submit">

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


                <!-- Action -->
                <div class="grid grid-cols-2 gap-4 mt-6">

                    <!-- Log in button -->
                    <PrimaryButton
                        background="primary-500"
                        hover="primary-400"
                        color="white"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        {{ $t('confirm') }}
                    </PrimaryButton>
                </div>
            </form>
        </Auth>
    </PageLayout>
</template>

<script setup>
    import { Head, useForm } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Auth from '@/Components/templates/Auth.vue';
    import Input from '@/Components/form/Input.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    /** Page content. */
    const content = {
        title: "Register",
        description: "Log in",
        link: {
            text: "log in",
            href: "login"
        }
    }

    const form = useForm({
        password: '',
    });

    const submit = () => {
        form.post(route('password.confirm'), {
            onFinish: () => form.reset(),
        });
    };
</script>
