<template>
    <AuthLayout :title="$t('header_confirm_password')" :description="$t('confirm_password_info')">
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
                <PrimaryButton type="submit" :disabled="form.processing" :label="$t('confirm')" />
            </div>
        </form>
    </AuthLayout>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import AuthLayout from '@/Layouts/AuthLayout.vue';
    import Auth from '@/Components/templates/Auth.vue';
    import Input from '@/Components/form/Input.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    const form = useForm({
        password: '',
    });

    const submit = () => {
        form.post(route('password.confirm'), {
            onFinish: () => form.reset(),
        });
    };
</script>
